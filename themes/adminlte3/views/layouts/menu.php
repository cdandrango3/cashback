<?php

use yii\helpers\Url;
?>
<!-- Brand Logo -->
<a href="<?= Url::to(['site/index']) ?>" class="brand-link">
    <img src="<?= Yii::getAlias('@web') . "/images/logos/isotipo.png"; ?>" class="brand-image img-circle elevation-3" alt="Cashbook Logo" style="opacity: .8">
    <span class="brand-text font-weight-light">Cashbook</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="https://via.placeholder.com/160" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">Admin</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->

            <li class="nav-item">
                <a href="<?= Url::to(['site/index']) ?>" class="nav-link">
                    <i class="nav-icon fas fa-home"></i>
                    <p>
                        Inicio
                    </p>
                </a>
            </li>

            <li class="nav-item has-treeview menu-closed">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                        Contabilidad
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= Url::to(['accountingseats/index']) ?>" class="nav-link">
                            <p>Asientos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::to(['accountingexercises/index']) ?>" class="nav-link">
                            <p>Ejercicios Contables</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::to(['chartaccounts/index'], $schema = true) ?>" class="nav-link">
                            <p>Plan de Cuentas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::to(['costcenter/index'], $schema = true) ?>" class="nav-link">
                            <p>Centros de Costos</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview menu-closed">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Personas
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= Url::to(['person/index'], $schema = true) ?>" class="nav-link">
                            <p>Personas</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview menu-closed">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-clipboard"></i>
                    <p>
                        Transacciones
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview">
                    <li class="nav-item has-treeview menu-closed">
                        <a href="<?= Url::to(['cliente/index']) ?>" class="nav-link">
                            <p>
                                Compra/Venta
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <p>Documentos</p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= Url::to(['cliente/index', 'tipos' => "Cliente"]) ?>" class="nav-link">
                                    <p>Clientes</p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= Url::to(['cliente/index', 'tipos' => "Proveedor"]) ?>" class="nav-link">
                                    <p>Proveedores</p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <p>Físicos y Otros</p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <p>DAU</p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <p>Anulaciones</p>
                                </a>
                            </li>
                        </ul>

                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview menu-closed">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-clipboard"></i>
                    <p>
                        Servicios/Productos
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= Url::to(['product/create'], $schema = true) ?>" class="nav-link">
                            <p>Servicios/Productos</p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item has-treeview menu-closed">
                        <a href="#" class="nav-link">
                            <p>
                                Configuraciones
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <p>Categorias</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->