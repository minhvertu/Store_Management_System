import { createStore } from "vuex";

export default createStore({
  state: {
    hideConfigButton: false,
    isPinned: true,
    showConfig: false,
    sidebarType: "bg-white",
    isRTL: false,
    mcolor: "",
    darkMode: false,
    isNavFixed: false,
    isAbsolute: false,
    showNavs: true,
    showSidenav: true,
    showNavbar: true,
    showFooter: true,
    showMain: true,
    cart: [],
    layout: "default"
  },
  mutations: {
    addToCart(state, product) {
        state.cart.push(product);
        localStorage.setItem('cart', JSON.stringify(state.cart));

    },
    removeFromCart(state, index) {
        state.cart.splice(index, 1); // Xóa sản phẩm khỏi giỏ hàng bằng cách sử dụng splice
      },


    toggleConfigurator(state) {
      state.showConfig = !state.showConfig;
    },
    navbarMinimize(state) {
      const sidenav_show = document.querySelector(".g-sidenav-show");

      if (sidenav_show.classList.contains("g-sidenav-hidden")) {
        sidenav_show.classList.remove("g-sidenav-hidden");
        sidenav_show.classList.add("g-sidenav-pinned");
        state.isPinned = true;
      } else {
        sidenav_show.classList.add("g-sidenav-hidden");
        sidenav_show.classList.remove("g-sidenav-pinned");
        state.isPinned = false;
      }
    },
    sidebarType(state, payload) {
      state.sidebarType = payload;
    },
    navbarFixed(state) {
      if (state.isNavFixed === false) {
        state.isNavFixed = true;
      } else {
        state.isNavFixed = false;
      }
    }
  },
  actions: {
    toggleSidebarColor({ commit }, payload) {
      commit("sidebarType", payload);
    },
    addToCart({ commit }, product) {
        commit('addToCart', product);
      },
      removeFromCart({ commit }, index) {
        commit("removeFromCart", index); // Gọi mutation để xóa sản phẩm khỏi giỏ hàng
      },

  },
  getters: {
    cartItems(state) {
        return state.cart;
      },
  }
});
