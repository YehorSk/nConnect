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
          <li class="nav-item dropdown active dropdown-slide">
            <a class="nav-link" href="#"  data-toggle="dropdown">Home
              <span>/</span>
            </a>
            <!-- Dropdown list -->
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#">Homepage</a>
              <a class="dropdown-item" href="#">Homepage 2</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Speakers
              <span>/</span>
            </a>
          </li>
          <li class="nav-item dropdown dropdown-slide">
            <a class="nav-link" href="#" data-toggle="dropdown">Pages<span>/</span></a>
            <!-- Dropdown list -->
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#">About Us</a>
              <a class="dropdown-item" href="#">Single Speaker</a>
              <a class="dropdown-item" href="#">Gallery</a>
              <a class="dropdown-item" href="#">Gallery-02</a>
              <a class="dropdown-item" href="#">Testimonial</a>
              <a class="dropdown-item" href="#">Pricing</a>
              <a class="dropdown-item" href="#">FAQ</a>
              <a class="dropdown-item" href="#">404</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Schedule<span>/</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Sponsors<span>/</span></a>
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
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
        <a href="#" class="ticket">
          <img src="/images/icon/ticket.png" alt="ticket">
          <span>Buy Ticket</span>
        </a>
      </div>
    </div>
  </nav>
</template>
<script setup lang="ts">
</script>