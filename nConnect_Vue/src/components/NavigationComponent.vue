<template>
  <nav class="navbar main-nav border-less fixed-top navbar-expand-lg p-0">
    <div class="container-fluid p-0">
      <!-- logo -->
      <a class="navbar-brand" href="index.html">
        <img src="/images/logo.png" alt="logo">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="fa fa-bars"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <router-link
                to="/" class="nav-link">Home<span>/</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
                to="/speakers" class="nav-link">Speakers<span>/</span>
            </router-link>
          </li>
          <li class="nav-item dropdown dropdown-slide">
            <a class="nav-link" href="#" data-toggle="dropdown">Pages<span>/</span></a>
            <!-- Dropdown list -->
            <div class="dropdown-menu">
              <router-link
                  to="/aboutus" class="dropdown-item">About Us
              </router-link>
              <router-link
                  to="/gallery" class="dropdown-item">Gallery
              </router-link>
              <router-link
                  to="/testimonial" class="dropdown-item">Testimonial
              </router-link>
              <router-link
                  to="/faq" class="dropdown-item">FAQ
              </router-link>
            </div>
          </li>
          <li class="nav-item">
            <router-link
                to="/schedule" class="nav-link">Schedule<span>/</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
                to="/sponsors" class="nav-link">Sponsors<span>/</span>
            </router-link>
          </li>
          <li class="nav-item dropdown dropdown-slide">
            <a class="nav-link" href="#"  data-toggle="dropdown">News
              <span>/</span>
            </a>
            <!-- Dropdown list -->
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#">News without sidebar</a>
              <a class="dropdown-item" href="#">News with right sidebar</a>
              <a class="dropdown-item" href="#">News with left sidebar</a>
              <a class="dropdown-item" href="#">News Single</a>
            </div>
          </li>
          <li class="nav-item">
            <router-link
                to="/contact" class="nav-link">Contact<span>/</span>
            </router-link>
          </li>
        </ul>
        <a href="#" class="ticket">
          <img src="/images/icon/ticket.png" alt="ticket">
          <span>REGISTRÁCIA</span>
        </a>
      </div>
    </div>
  </nav>
</template>
<script setup lang="ts">
</script>