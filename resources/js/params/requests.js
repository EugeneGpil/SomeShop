export const login = {
    url: '/api/auth/login',
    method: 'post'
};

export const me = {
    url: '/api/auth/me',
    method: 'post'
};

export const refresh = {
    url: '/api/auth/refresh',
    method: 'post'
};

export const logout = {
    url: '/api/auth/logout',
    method: 'post'
};

export const getUserlist = {
    method: 'get',
    getUrl: (params) => {
        return `/api/users/${params.page}/${params.per_page}/${params.search}`
    }
};

export const getUser = {
    method: 'get',
    getUrl: (params) => {
        return `/api/user/${params.id}${params.lang ? `/${params.lang}` : ''}`
    }
};

export const getOrderStatuses = {
    method: 'get',
    url: '/api/order_statuses'
};

export const getOrder = {
    method: 'get',
    getUrl: (params) => {
        return `/api/order/${params.id}`;
    }
};

export const getProductlist = {
    method: 'get',
    getUrl: (params) => {
        let url = `/api/products/${params.current_page}/${params.per_page}`;
        if (params.search) {
            url += `/${params.search}`;
        }
        return url;
    }
};

export const updateOrder = {
    method: 'patch',
    url: '/api/order'
};

export const updateUser = {
    method: 'patch',
    url: '/api/user'
};