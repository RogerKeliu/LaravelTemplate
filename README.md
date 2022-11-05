## Instal·lació
### Arxiu .env
> - Copiar l'arxiu .env.example amb el nom de .env.  
> - Cal omplir amb les dades necessàries l'arxiu .env.

### Php & Npm
> Un cop baixat el repo, i omplert l'arxiu .env, cal executar:
> - php composer install
> - npm install
> - php artisan migrate:fresh --seed
> - php artisan serve
> - npm run watch

## Rols i Permissos
> #### La lògica dels rols i permissos només funcionarà si les rutes que volem securitzar estan dins del middleware sanctum ja que sino no podrem accedir a Auth::user i coneixa els seus rols i permissos.

### Usuaris
> L'aplicació contindrà com a base 3 usuaris amb diferents rols.  
>
> | Usuari       | Email             | Password      | Rols   | Permissions             |
> | :----------- | :----------:      | -----------:  | -----: | -----:                  |
> |  Admin       | admin@admin.com   | adminadmin    | Admin  |  get users,<br/>, get products, <br/>  view admin-products  |
> |  Worker      | worker.worker.com | workerworker  | Worker | get users, <br/> get products   |
> |  Guest       | guest@guest.com   | guestguest    | Guest  | get users               |



### Permissos

> Els permissos get users i get products, ens permetràn fer peticions get amb axios per tal de obtenir
> la seva respectiva informació. 
>> - *get users* s'utilitza t'han a la pantalla de users com a la pantalla de api permissions.  
>
>> - *get products* s'utilitza a la pantalla de api permissions i si probem de veure la informació 
     amb l'usuari guest veurem que ens retorna method not allowed.
>
>> - *view admin-products* ens permetrà accedir a la finestra products-admin. Veurem que si intentem accedir a la url
>> /app/admin-products sense aquest permis, ens redirigirar a la pàgina /app/not-allowed.  

### Lògica

> Veurem que els permissos tenen un guard_name 'web'.
> 
> Ja que en el nostre cas, totes les peticións són api utilitznat axios, pero representen també les vistes dels nostres models amb la informació necessària. 
> 

### Lògica CRUD.
> La lògica crud és la que ens permetrà interectuar amb els nostres models.
> Bàsicament, create, read, update i delete. Tot i això es poden implementar tans mètodes com es vulguin seguin les "policies" de laravel.
> 
> En el nostre cas són les peticions get users i get products.
> La lògica es troba als seus respectius controlladors.
```php

    namespace App\Http\Controllers\Api;
    
    // A través de Auth::user accedim als permissos.
    // la funció can és propia de laravel que cridarà el mètode passat coma
    // primer paràmetra de les policies de laravel.
    // el segon paràmetre hi envia el model amb el que interectuem i
    // opcionalment el guard dels seus permissos.
    
    if( Auth::user()->can('viewAny', [User::class, 'web']) ) {
            return response()->json([
                'data' => User::get()->toArray(),
                'status'  => 200,
            ]);
        }

        return response()->json([
            'message' => 'Method Not Allowed',
            'status'  => 405,
        ]);
```
> En el namespace App\Polices hi ha un document helpers.php que conte una funció la qual ens retornarà 
> segons l'usuari si pot realitzar o no aquella acció.
```php
    namespace App\Policies;
    
    public function viewAny(User $user, $guard)
    {
        return Helpers::userCanDoAction($user, 'get users', $guard);
    }
```
### Lògica VIEWS.
> La lògica views és la que ens permetrà accedir a una ruta de Vue, i per tant la lògica d'aquesta part serà al router del nostre modul.
> En el nostre cas appRouter


```javascript

    Route
    {
        path: "/app/admin-products",
        name: "admin-products",
        component: AdminProduct,
        async beforeEnter(to, from, next) {
            if (await hasPermission(to)) {
                next();
            } else {
                next('/app/not-allowed');
            }
        }
    }
    
    function hasPermission(to) {
        return axios
            .post("/api/canView", {
                'route' : to
            })
            .then((response) => {
                if(response.data === true) {
                    return true;
                } else {
                    return false;
                }
            })
            .catch((error) => {
                return false;
            });
    }api
```

> Com podem observar en el mètode canview, acabem cridant una ruta post on nonmés li enviarem la ruta a la que volem accedir.  
>
> En el controlador MeController en el mètode canView és on trobarem la lògica backend per tal de implementar permissos a les rutes de vue.
>
> Basicament afegirem "view" al nom de la ruta a la que volem accedir hi ha través de l'Auth::user comprovar-ho.

```php

public function canView(Request $request) {
        $route = 'view ' . $request->input('route')['name'];
        if(Helpers::userCanDoAction(Auth::user(), $route)) {
            return response()->json(true, 200);
        } else {
            return response()->json(false, 200);
        }
    }

    //Helpers.php
     public static function userCanDoAction($user, $action, $guard = 'web') {
        $userPermissions = $user->getPermissionsViaRoles();
        foreach($userPermissions as $permission) {
            if ($permission->name === $action) {
                return true;
            }
        }
        return false;
    }

```
## Traduccións
Per les traduccions utiltizem el paquet Vue18n.
> Les traduccions es troben al document vuei18n.js tot i que es podria exportar a documents.json i importar-los a la propietat vue18n

```js

const i18n = createI18n({
    legacy: false,
    fallbackLocale: 'en',
    locale: "en",
    globalInjection: true,
    messages: my()
});

```
> La funcio my retornarà un objecte json amb les traduccións dels diferents llenguatges.

> Els usuaris contenen una propietat 'lang' que contindrà la preferència de llenguatge de l'usuari.
> Per accedir a aquesta informació utilitzarem la ruta /me/lang/ que es cridarà al index de la nostre Layout i ho assignem a la propietat de vue18n.

```js

 watch: {
        locale: function (val) {
            this.$i18n.locale = val;
        },
    },
  mounted() {
    this.getMe();
  },
  methods: {
    getMe() {
        console.log('aa');
        axios
        .get("/api/me/profile/lang", {})
        .then((response) => {
          this.locale = response.data;
        })
        .catch((error) => {
          this.error = console.log(error);
        });
    },

```





