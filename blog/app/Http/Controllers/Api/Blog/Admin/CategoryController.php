<?php

namespace App\Http\Controllers\Api\Blog\Admin;

//use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use App\Http\Requests\BlogCategoryCreateRequest;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use App\Http\Requests\BlogCategoryUpdateRequest;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //dd(__METHOD__);
        $paginator = BlogCategory::orderBy('id', 'desc')->paginate(5);

        return $paginator;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        //dd(__METHOD__);
        $data = $request->all(); // Отримуємо масив даних, які надійшли з POST-запиту

        // Якщо псевдонім (slug) порожній, генеруємо його з назви (title)
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Створюємо новий об'єкт моделі з отриманими даними
        $item = new BlogCategory($data);

        // Зберігаємо запис у базу даних
        $result = $item->save();

        if ($result) {
            return [
                'success' => true,
                'message' => 'Успішно створено',
                'item' => $item // Повертаємо новостворений запис
            ];
        } else {
            return ['message' => 'Помилка створення'];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Шукаємо категорію в базі даних за її ID
        $item = BlogCategory::find($id);

        // Якщо категорію з таким ID не знайдено, повертаємо помилку 404
        if (empty($item)) {
            return response()->json(['message' => "Запис id=[{$id}] не знайдено"], 404);
        }

        // Якщо знайдено — Laravel автоматично перетворить об'єкт у JSON і поверне його
        return $item;
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        // 1. Шукаємо об'єкт в базі по ID
        $item = BlogCategory::find($id);

        if (empty($item)) {
            return response()->json(['message' => "Запис id=[{$id}] не знайдено"], 404);
        }

        // 2. Отримуємо валідні дані
        $data = $request->all();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // 3. Оновлюємо дані об'єкта і зберігаємо в БД
        $result = $item->update($data);

        // 4. Повертаємо результат
        if ($result) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'item' => $item
            ];
        } else {
            return ['message' => 'Помилка збереження'];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //dd(__METHOD__);
    }
}
