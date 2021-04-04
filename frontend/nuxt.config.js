import colors from "vuetify/es5/util/colors";

export default {
  telemetry: false,
  // Default target is server
  target: "static",

  server: {
    port: 80,
    host: "0.0.0.0"
  },

  // Disable server-side rendering (https://go.nuxtjs.dev/ssr-mode)
  ssr: false,

  // Global page headers (https://go.nuxtjs.dev/config-head)
  head: {
    title: "Primer test - PK",
    meta: [
      {
        charset: "utf-8"
      },
      {
        name: "viewport",
        content: "width=device-width, initial-scale=1"
      },
      {
        hid: "description",
        name: "description",
        content: ""
      }
    ],
    link: [
      {
        rel: "icon",
        type: "image/x-icon",
        href: "/favicon.jpg"
      }
    ]
  },

  // Global CSS (https://go.nuxtjs.dev/config-css)
  css: ["~/assets/css/main"],

  // Plugins to run before rendering page (https://go.nuxtjs.dev/config-plugins)
  plugins: ["~/plugins/axios"],

  // Auto import components (https://go.nuxtjs.dev/config-components)
  components: true,

  // Modules for dev and build (recommended) (https://go.nuxtjs.dev/config-modules)
  buildModules: [
    // https://github.com/microcipcip/cookie-universal/tree/master/packages/cookie-universal-nuxt
    "cookie-universal-nuxt",
    // https://go.nuxtjs.dev/vuetify
    "@nuxtjs/vuetify",
    // https://github.com/nuxt-community/moment-module
    ["@nuxtjs/moment", { timezone: true }]
  ],

  // Modules (https://go.nuxtjs.dev/config-modules)
  modules: ["@nuxtjs/axios", "@nuxtjs/auth", "@nuxtjs/toast"],

  // Plugins (https://go.nuxtjs.dev/config-plugins)

  axios: {
    baseURL: process.env.BACKEND_URL,
    credentials: true,
    headers: {
      Accept: "application/json",
      "X-Requested-With": "XMLHttpRequest",
      "Content-Type": "application/json"
    }
  },

  auth: {
    redirect: {
      home: false
    },
    strategies: {
      local: {
        endpoints: {
          login: {
            url: "/login",
            method: "post"
          },
          logout: {
            url: "/logout",
            method: "get"
          },
          user: {
            url: "/api/user",
            method: "get",
            propertyName: false
          }
        },
        tokenRequired: false,
        tokenType: false
      }
    },
    resetOnError: true
  },

  router: {
    middleware: ["auth"]
  },

  // Vuetify module configuration (https://go.nuxtjs.dev/config-vuetify)
  vuetify: {
    customVariables: ["~/assets/variables.scss"],
    theme: {
      dark: true,
      themes: {
        dark: {
          primary: colors.blue.darken2,
          accent: colors.grey.darken3,
          secondary: colors.amber.darken3,
          info: colors.teal.lighten1,
          warning: colors.amber.base,
          error: colors.deepOrange.accent4,
          success: colors.green.accent3
        }
      }
    }
  },

  toast: {
    singleton: true,
    keepOnHover: true,
    iconPack: "mdi",

    register: [
      {
        name: "success",
        message: "success default message",
        options: {
          duration: 10000,
          icon: "check-circle",
          position: "top-center",
          type: "success"
        }
      },
      {
        name: "exception",
        message: "exception default message",
        options: {
          duration: null,
          icon: "alert",
          position: "top-center",
          type: "error"
        }
      },
      {
        name: "auth",
        message: "auth default message",
        options: {
          duration: 10000,
          icon: "alert",
          position: "bottom-center",
          singleton: true,
          type: "error"
        }
      },
      {
        name: "notFound",
        message: "Model not found",
        options: {
          duration: 10000,
          icon: "alert",
          position: "bottom-center",
          type: "error"
        }
      },
      {
        name: "validation",
        message: "validation default message",
        options: {
          duration: 10000,
          icon: "alert",
          position: "bottom-center",
          type: "error"
        }
      }
    ]
  },

  // Build Configuration (https://go.nuxtjs.dev/config-build)
  build: {
    transpile: ["@nuxtjs/auth"]
  }
};
