
<template>
  <div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <router-link class="navbar-brand" to="/">Магазин</router-link>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            <li class="nav-item">
              <router-link to="/" class="nav-link">Главная</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/products" class="nav-link">Каталог</router-link>
            </li>
<!--            <li class="nav-item dropdown">-->
<!--              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">-->
<!--                Dropdown-->
<!--              </a>-->
<!--              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">-->
<!--                <li><a class="dropdown-item" href="#">Action</a></li>-->
<!--                <li><a class="dropdown-item" href="#">Another action</a></li>-->
<!--                <li><hr class="dropdown-divider"></li>-->
<!--                <li><a class="dropdown-item" href="#">Something else here</a></li>-->
<!--              </ul>-->
<!--            </li>-->
<!--            <li class="nav-item">-->
<!--              <a class="nav-link disabled">Disabled</a>-->
<!--            </li>-->
          </ul>

          <a @click.prevent="openCart()" href="" class="text-white pe-4"><i class="fas fa-shopping-cart"></i></a>

<!--          Поиск (добавить позже)   -->

<!--          <form class="d-flex">-->
<!--            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">-->
<!--            <button class="btn btn-outline-success" type="submit">Search</button>-->
<!--          </form>-->

        </div>
      </div>
    </nav>

    <aside class="cart" id="cart">
<!--      <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white" style="width: 380px;">-->
<!--        <a href="/" class="d-flex align-items-center flex-shrink-0 p-3 link-dark text-decoration-none border-bottom">-->
<!--          <svg class="bi me-2" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>-->
<!--          <span class="fs-5 fw-semibold">List group</span>-->
<!--        </a>-->
<!--        <div class="list-group list-group-flush border-bottom scrollarea">-->
<!--          <a href="#" class="list-group-item list-group-item-action active py-3 lh-tight" aria-current="true">-->
<!--            <div class="d-flex w-100 align-items-center justify-content-between">-->
<!--              <strong class="mb-1">List group item heading</strong>-->
<!--              <small>Wed</small>-->
<!--            </div>-->
<!--            <div class="col-10 mb-1 small">Some placeholder content in a paragraph below the heading and date.</div>-->
<!--          </a>-->
<!--        </div>-->
<!--      </div>-->
      <div>
        <ul>
        </ul>
      </div>
    </aside>

    <router-view></router-view>

    <footer>
    </footer>
  </div>
</template>

<script>

export default {
  name: 'App',

  methods: {
    openCart() {
      let cart = document.getElementById('cart')
      if (cart.classList.contains('opened')) {
        cart.classList.remove('opened')
        document.getElementById('cart').style.right = '-380px'
      } else {
        cart.classList.add('opened')
        document.getElementById('cart').style.right = '0'
      }
    }
  }
}
</script>

<style>

</style>
