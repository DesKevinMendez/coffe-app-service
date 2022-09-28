import {
    mdiCart,
    mdiDesktopMac,
    mdiCoffeeMaker,
    mdiBadminton,
    mdiBucketOutline,
    mdiBaguette,
    mdiAccountMultiple
} from "@mdi/js";

export default [
    {
        to: "/",
        icon: mdiDesktopMac,
        label: "Inicio",
    },
    {
        to: "/orders",
        label: "Ordenes",
        icon: mdiCart,
    },
    {
        to: "/sales",
        label: "Ventas",
        icon: mdiBucketOutline,
    },
    {
        // Key should be unique for each submenus object
        // It is required for open/close logic
        key: "submenus-1",
        label: "Productos",
        icon: mdiCoffeeMaker,
        menuSecondary: [
            {
                to: "/profile",
                label: "Permanentes",
                icon: mdiBadminton,
            },
            {
                to: "/profile",
                label: "Temporales",
                icon: mdiBaguette,
            },
        ],
    },

    {
      to: "/users",
      label: "Usuarios",
      icon: mdiAccountMultiple,
  },
];
