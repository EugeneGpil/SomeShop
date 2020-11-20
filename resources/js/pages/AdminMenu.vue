<template>
    <div class='admin-menu'>
        <router-link 
            class='button admin-menu__button' :to="{name: 'userlist'}"
        >{{ $t('admin_menu.users') }}</router-link>

        <router-link 
            class='button admin-menu__button' :to="{name: 'products'}"
        >{{ $t('admin_menu.products') }}</router-link>

        <router-link
            class='button admin-menu__button' :to="{name: 'categories'}"
        >{{ $t('admin_menu.categories') }}</router-link>

        <router-link
            class='button admin-menu__button' :to="{name: 'categiry_groups'}"
        >{{ $t('admin_menu.category_groups') }}</router-link>
 
        <router-link
            class='button admin-menu__button' :to="{name: 'order_statuses'}"
        >{{ $t('admin_menu.order_statuses') }}</router-link>

        <router-link class='button admin-menu__button' :to="{name: 'colors'}"
        >{{ $t('admin_menu.colors') }}</router-link>

        <router-link class='button admin-menu__button' :to="{name: 'materials'}"
        >{{ $t('admin_menu.materials') }}</router-link>

        <router-link class='button admin-menu__button' :to="{name: 'guarantees'}"
        >{{ $t('admin_menu.guarantees') }}</router-link>
    </div>
</template>

<script>
export default {
    name: 'admin_menu'
}
</script>
