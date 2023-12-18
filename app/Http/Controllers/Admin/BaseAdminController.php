<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class BaseAdminController extends Controller
{
    protected $resource = '';
    protected $model = '';

    private function fillFormParams(array $fields, Model $model): array
    {
        foreach ($fields as $key => $field) {
            if ($field['type'] == 'password')
                continue;

            if ($field['type'] == 'multiple') {
                $fields[$key] = $this->buildMultiple($field, $model);
                continue;
            }

            if ($field['element'] == 'map') {
                $key_latitude = $field['input_latitude'];
                $key_longitude = $field['input_longitude'];

                $fields[$key]['value_latitude'] = $model->$key_latitude;
                $fields[$key]['value_longitude'] = $model->$key_longitude;
                continue;
            }

            $name = $field['name'];

            if (isset($model->$name))
                $fields[$key]['value'] = $model->$name;
        }

        return $fields;
    }

    private function buildMultiple(array $field, Model $model): array
    {
        $relation_name = $field['name'];

        $options = [];
        $selected = $model->$relation_name->toArray();
        if ($field['multiple']['active'] == '')
            $items = $field['relation']::get()->toArray();
        else
            $items = $field['relation']::where($field['multiple']['active'], '=', '1')->get()->toArray();

        foreach ($items as $item) {
            $option = [
                'label' => $item[$field['multiple']['label']],
                'selected' => false
            ];

            foreach ($selected as $select)
                if ($select[$field['multiple']['value']] == $item[$field['multiple']['value']]) {
                    $option['selected'] = true;
                    break;
                }

            $options[$item[$field['multiple']['value']]] = $option;
        }

        $field['options'] = $options;

        return $field;
    }

    protected function view(string $callback, string $method, Model|null $model = null): View|RedirectResponse
    {
        $fields = config('admin.' . $this->resource);

        if ($fields === null)
            return redirect()->route($this->resource . '.index')->with(['error' => 'Отсутствует конфигурация формы.']);

        if ($model !== null)
            try {
                $fields = $this->fillFormParams($fields, $model);
            } catch (\Exception $e) {
                return redirect()->route($this->resource . '.index')->with(['error' => 'Ошибка в конфигурации формы: ' . $e->getMessage()]);
            }

        return view('admin.form',
            [
                'callback' => $this->resource . '.' . $callback,
                'method' => $method,
                'fields' => $fields,
                'id' => $model->id ?? null,
                'title' => 'Создать / Редактировать запись'
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|RedirectResponse
    {
        return $this->view('store', 'post', new $this->model);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|RedirectResponse
    {
        return $this->view('update', 'put', $this->model::findOrFail($id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $this->model::findOrFail($id)->delete();
        return redirect()->route($this->resource . '.index')->with('status', 'Запись успешно удалена.');
    }

    /**
     * Display a listing of the resource.
     */
    protected function viewList(array       $paginate,
                                string      $title,
                                string      $filedLabel,
                                string|null $template = null,
                                array       $params = [],
                                string|null $additional = null,
                                string|null $fieldActive = 'active'): View
    {
        $params['next_page_url'] = $paginate['next_page_url'];
        $params['prev_page_url'] = $paginate['prev_page_url'];
        $params['links'] = $paginate['links'];

        $params['items'] = $paginate['data'];
        $params['field_label'] = $filedLabel;
        $params['title'] = $title;
        $params['resource'] = $this->resource;
        $params['additional'] = $additional;
        $params['field_active'] = $fieldActive;

        return view($template ?? 'admin.index', $params);
    }
}