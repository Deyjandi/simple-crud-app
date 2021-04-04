export default function({ $axios, $auth, $toast }) {
  $axios.interceptors.response.use(
    response => {
      return response;
    },
    error => {
      if (error.response && error.response.data) {
        const message = error.response.data.message;
        $toast.clear();

        switch (error.response.status) {
          // exception
          case 500:
            $toast.clear();
            $toast.global.auth().text(message);
            break;
          // validation error
          case 422:
            $toast.global.validation().text(message);
            break;
          case 404:
            $toast.clear();
            $toast.global.notFound();
            break;
          // unauthorized error
          case 401:
            if (!["login", "logout"].includes(error.response.config.url)) {
              $auth.logout();
            } else {
              $toast.clear();
              $toast.global.auth().text(message);
            }
            break;
        }

        return Promise.reject(error.response.data);
      } else return Promise.reject(error.message);
    }
  );
}
