<template>
  <section class="map">
    <!-- Google Map -->
    <div id="map"></div>
    <div class="address-block">
      <h4>Študentské centrum UKF</h4>
      <ul class="address-list p-0 m-0">
        <li><i class="fa fa-home"></i><span> Dražovská 2, Nitra</span></li>
        <li><i class="fa fa-phone"></i><span> +421 902 170 744</span></li>
        <li><i class="fa fa-envelope"></i><span> info@nconnect.sk </span></li>
      </ul>
      <br>
      <v-dialog max-width="700">
        <template v-slot:activator="{ props: activatorProps }">
          <v-btn
              v-bind="activatorProps"
              color="surface-variant"
              text="Kde sa nachadzame?"
              variant="flat"
          ></v-btn>
        </template>
        <template v-slot:default="{ isActive }">
          <v-card>
            <v-img loading="lazy"
                   color="surface-variant"
                   height="400"
                   src="../images/background/location.jpg"
                   cover></v-img>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                  text="Close"
                  @click="isActive.value = false"
              ></v-btn>
            </v-card-actions>
          </v-card>
        </template>
      </v-dialog>
    </div>

  </section>
</template>
<script setup>
</script>