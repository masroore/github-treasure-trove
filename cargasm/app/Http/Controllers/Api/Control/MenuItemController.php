<?php

namespace App\Http\Controllers\Api\Control;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuItemRequest;
use App\Http\Requests\SyncRequest;
use App\Http\Resources\Control\LanguageResource;
use App\Http\Resources\Control\MenuItemResource;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MenuItemController extends Controller
{
    /**
     * @api {get} /api/v1/control/menus/{menuId}/items 01. Список пунктов меню
     * @apiVersion 1.0.0
     * @apiName GetMenuItems
     * @apiGroup 31.Меню
     *
     * @apiParam {String} [_lang] Фильтрация по языку
     */
    public function index(Menu $menu)
    {
        $this->authorize('menu-manage');

        return MenuItemResource::collection($menu->items()->byLangs()->get());
    }

    /**
     * @api {get} /api/v1/control/menus/{menuId}/items/create 02. Создать пункт меню (форма)
     * @apiVersion 1.0.0
     * @apiName GetMenuItemCreate
     * @apiGroup 31.Меню
     */
    public function create(Menu $menu)
    {
        $this->authorize('menu-manage');

        return response()->json([
            'form' => $this->getFormAdditional(new MenuItem()),
        ]);
    }

    /**
     * @api {post} /api/v1/control/menus/{menuId}/items 03. Сохранить пункт меню
     * @apiVersion 1.0.0
     * @apiName PostMenuItem
     * @apiGroup 31.Меню
     *
     * @apiParam {String} name Название
     * @apiParam {String=path-путь,delimiter-разделитель} type Тип пункта
     * @apiParam {String} path Путь (url, slug,...)
     * @apiParam {String} target Target
     * @apiParam {String} class HTML class
     * @apiParam {String} rel Rel
     * @apiParam {String} img Path to img
     * @apiParam {String} lang Язык
     */
    /**
     * @apiParam {String} [translation_uuid] UUID переводимой модели (для которой создаем перевод)
     */
    public function store(Menu $menu, MenuItemRequest $request)
    {
        $this->authorize('menu-manage');

        $menu->items()->create($request->validated());

        return response()
            ->json(['message' => trans('system.actions.store.success')], Response::HTTP_CREATED);
    }

    /**
     * @api {get} /api/v1/control/menus/items/{menuItemId}/edit 04. Редактировать пункт меню (форма)
     * @apiVersion 1.0.0
     * @apiName GetMenuItemEdit
     * @apiGroup 31.Меню
     */
    public function edit(MenuItem $menuItem)
    {
        $this->authorize('menu-manage');

        return MenuItemResource::make($menuItem)->additional([
            'form' => $this->getFormAdditional($menuItem),
        ]);
    }

    /**
     * @api {patch} /api/v1/control/menus/items/{menuItemId} 05. Обновить пункт меню
     * @apiVersion 1.0.0
     * @apiName PatchMenuItem
     * @apiGroup 31.Меню
     */
    public function update(MenuItemRequest $request, MenuItem $menuItem)
    {
        $this->authorize('menu-manage');

        $menuItem->update($request->validated());

        return response()
            ->json(['message' => trans('system.actions.update.success')], Response::HTTP_ACCEPTED);
    }

    /**
     * @api {post} /api/v1/control/menus/items/sync 07. Синхронизация записей
     * @apiVersion 1.0.0
     * @apiName PostMenuItemSync
     * @apiGroup 31.Меню
     *
     * @apiDescription Метод позволяет масово изменять, добавлять, удалять записи.
     *
     * @apiParam {Array} [deleted] Массив ID-дов для удаления.
     * @apiParam {Array} [changed] Массив обьектов записей и их полей для изменения.
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *          "deleted": [4711, 234]
     *     }
     */
    public function sync(SyncRequest $request)
    {
        $this->authorize('menu-manage');

        if ($request->deleted) {
            MenuItem::whereIn('id', $request->deleted)->delete();
        }

        if ($request->changed) {
            foreach ($request->changed as $item) {
                if (isset($item['id']) && ($model = MenuItem::find($item['id']))) {
                    //$model->update(\Arr::only($item, 'is_active'));
                }
            }
        }

        return response()
            ->json(['message' => trans('system.actions.update.success')])
            ->setStatusCode(\Illuminate\Http\Response::HTTP_OK);
    }

    /**
     * @api {post} /api/control/menus/items/order 08. Сохранить иерархию
     * @apiGroup 92.Menu
     * @apiName PostMenuItemOrder
     * @apiGroup 31.Меню
     *
     * @apiParam {Array} tree Array hierarchical tree
     *
     * @apiParamExample {json} Example request:
     * {
     * "tree": [
     *     {
     *         "id": 17
     *     },
     *     {
     *         "id": 9
     *     },
     *     {
     *         "id": 13,
     *         "children": [
     *             {
     *                 "id": 15,
     *                 "children": [
     *                      "id": 17
     *                 ]
     *             }
     *         ]
     *     }
     * ]
     * }
     */
    public function order(Request $request)
    {
        $this->authorize('menu-manage');

        $this->validate($request, [
            'tree' => 'required|array',
        ]);

        $entities = $this->buildLinearArraySort($request->tree);

        foreach ($entities as $item) {
            optional(MenuItem::find($item['id']))->update($item);
        }

        return response()
            ->json(['message' => trans('system.actions.update.success')], Response::HTTP_ACCEPTED);
    }

    protected function buildLinearArraySort(array $treeEntities, ?int $parentId = null, bool $useParent = true): array
    {
        $result = [];

        foreach ($treeEntities as $key => $entity) {
            $data = [];
            if (!empty($entity['id'])) {
                $data['id'] = (int) $entity['id'];
                $data['weight'] = $key;
                $useParent ? $data['parent_id'] = $parentId : null;
                $result[] = $data;
                if (!empty($entity['children'])) {
                    $result = array_merge(
                        $result,
                        $this->buildLinearArraySort(
                            $entity['children'],
                            $entity['id'],
                            $useParent
                        )
                    );
                }
            }
        }

        return $result;
    }

    protected function getFormAdditional(?Model $model = null): array
    {
        return [
            //'translations' => $model->getTranslationsList(),
            'types' => MenuItem::getTypesList(),
            'targets' => MenuItem::getTargetsList(),
            'languages' => LanguageResource::collection(get_languages()),
        ];
    }
}
