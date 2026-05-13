import { createRouter, createWebHistory } from "vue-router";
import TramitesList from "../views/TramitesList.vue";
import TramitesForm from "../views/TramiteForm.vue";
import InstitucionesForm from "../views/InstitucionForm.vue";

const routes = [
  {
    path: "/",
    name: "tramites-list",
    component: TramitesList
  },
  {
    path: "/tramites/create",
    name: "tramites-create",
    component: TramitesForm
  },
  {
    path: "/tramites/:id/edit",
    name: "tramites-edit",
    component: TramitesForm, props: true
  },
  {
    path: "/instituciones/create",
    name: "instituciones-create",
    component: InstitucionesForm
  }
];

export default createRouter({
  history: createWebHistory(),
  routes
});