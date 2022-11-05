import { createI18n } from "vue-i18n";

const i18n = createI18n({
    legacy: false,
    fallbackLocale: 'es',
    locale: "es",
    globalInjection: true,
    messages: my()
});

function my() {
    return {
        en: {
            message: {
                language: "English",
                greeting: "Hello !"
            },
            user: 'Users',
            api_permissions: 'Api Permissions',
            admin_products: 'Admin - Products',
            albarans: 'Albarans',
            assign_role_to_user: 'Assign Roles to User',
            escaner: 'Scan'
        },
        es: {
            message: {
                language: "Español",
                greeting: "Hola !"
            },
            user: 'Usuarios',
            api_permissions: 'Permisos Api',
            admin_products: 'Administracion - Productos',
            albarans: 'Albaranes',
            assign_role_to_user: 'Assignar Roles a Usuario',
            escaner: 'Escaner'
        },
        cat: {
            message: {
                language: "Català",
                greeting: "Hola !"
            },
            user: 'Usuaris',
            api_permissions: 'Permisos Api',
            admin_products: 'Administració - Productes',
            albarans: 'Albarans',
            assign_role_to_user: 'Assignar Rols a Usuari',
            escaner: 'Escàner'
        }
    }
}
export default i18n;
