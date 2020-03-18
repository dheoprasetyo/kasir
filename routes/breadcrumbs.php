<?php
Breadcrumbs::for('dashboard', function($trail){
    $trail->push('Dashboard', route('dashboard'));
});
Breadcrumbs::for('transaction', function($trail){
    $trail->parent('dashboard');
    $trail->push('Transaction', route('dashboard'));
});
Breadcrumbs::for('detailorder', function($trail){
    $trail->parent('transaction');
    $trail->push('Detail Order', route('detailorder'));
});