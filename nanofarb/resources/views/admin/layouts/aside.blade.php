<aside class="main-sidebar">
    <section class="sidebar">
      @include('admin.layouts.sidebar-menu.menu')
      {{--
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Меню</li>
        <li class="active">
          <a href="/admin">
            <i class="fa fa-dashboard"></i>
            <span>Главная</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-file-text-o"></i>
            <span>Материалы</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/admin/products"><i class="fa fa-circle-o text-green"></i> Товары</a></li>
            <li><a href="/admin/pages"><i class="fa fa-circle-o text-green"></i> Статическии страницы</a></li>
            <li><a href="/admin/sales"><i class="fa fa-circle-o text-green"></i> Акции</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-th"></i>
            <span>Структура</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview">
              <a href="#">
                <i class="fa fa-circle-o text-green"></i>
                <span>Рубрикатор</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="/admin/terms?vocabulary=product_categories"><i class="fa fa-circle-o text-green"></i> Категории товаров</a></li>
                <li><a href="/admin/terms?vocabulary=order_statuses"><i class="fa fa-circle-o text-green"></i> Статусы заказов</a></li>
                <li><a href="/admin/terms?vocabulary=payment_statuses"><i class="fa fa-circle-o text-green"></i> Статусы оплат</a></li>
                <li><a href="/admin/terms?vocabulary=types_trade_services"><i class="fa fa-circle-o text-green"></i> Виды торг. услуг</a></li>
                <li><a href="/admin/terms?vocabulary=faq_subjects"><i class="fa fa-circle-o text-green"></i> Темы для FAQ</a></li>
              </ul>
            </li>
            <li><a href="/admin/shop/attributes"><i class="fa fa-circle-o text-green"></i> Атрибуты</a></li>
            <li><a href="/admin/menu"><i class="fa fa-circle-o text-green"></i> Меню</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-cogs"></i>
            <span>Конфигурации</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/admin/variables"><i class="fa fa-circle-o text-green"></i> Настройка системы</a></li>
            <li><a href="/admin/cache-clear"><i class="fa fa-circle-o text-green"></i> Очистить кеш</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-chrome"></i>
            <span>Веб-формы</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/admin/forms/buy_one_click"><i class="fa fa-circle-o text-green"></i> Купить в один клик</a></li>
            <li><a href="/admin/forms/subscribers"><i class="fa fa-circle-o text-green"></i> Подписчики</a></li>
            <li><a href="/admin/forms/contacts"><i class="fa fa-circle-o text-green"></i> Контакты</a></li>
            <li><a href="/admin/forms/faq"><i class="fa fa-circle-o text-green"></i> Вопросы FAQ</a></li>
            <li><a href="/admin/forms/cooperation"><i class="fa fa-circle-o text-green"></i> Сотрудничество</a></li>
            <li><a href="/admin/forms/questions"><i class="fa fa-circle-o text-green"></i> Вопрос-ответ</a></li>
            <li><a href="/admin/product-reviews"><i class="fa fa-circle-o text-green"></i> Отзывы о товарах</a></li>
          </ul>
        </li>

        <li>
          <a href="/admin/orders">
            <i class="fa fa-shopping-cart"></i> <span>Заказы</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"> {{ \App\Models\Shop\Order::count() }}</span>
            </span>
          </a>
        </li>

        <li>
          <a href="/admin/users">
            <i class="fa fa-users"></i> <span>Пользователи</span>
          </a>
        </li>
      </ul>
      --}}
    </section>
  </aside>