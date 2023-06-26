export default [
    {
        path: '/customers',
        name: 'customers',
        component: () => import('@/views/jbs/customer/Listing.vue'),
    },
    {
        path: '/invoices',
        name: 'invoices',
        component: () => import('@/views/jbs/invoice/List.vue'),
    },
    {
        path: '/invoices/edit/:id',
        name: 'invoices-edit',
        component: () => import('@/views/jbs/invoice/Add.vue'),
    },
    {
        path: '/invoices/preview/:id',
        name: 'invoices-preview',
        component: () => import('@/views/jbs/invoice/Preview.vue'),
    },
]
