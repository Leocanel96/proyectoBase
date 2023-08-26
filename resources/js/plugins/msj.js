import 'izitoast/dist/css/iziToast.min.css'; // loading css
import iziToast from 'izitoast/dist/js/iziToast.min.js'; // you have access to iziToast now


iziToast.settings({
    timeout: 10000,
    resetOnHover: true,
    icon: 'material-icons',
    transitionIn: 'flipInX',
    transitionOut: 'flipOutX'
});

const Msj = {
    install(Vue) {
        Vue.prototype.$iziToast = {
            info(titulo, mensaje) {
                iziToast.info({
                    title: titulo,
                    message: mensaje,
                    position: 'topRight',
                    transitionIn: 'bounceInUp'
                });
            },
            warning(titulo, mensaje) {
                iziToast.warning({
                    title: titulo,
                    message: mensaje,
                    position: 'topRight',
                    transitionIn: 'bounceInUp'
                });
            },
            error(titulo, mensaje) {
                iziToast.error({
                    title: titulo,
                    message: mensaje,
                    position: 'topRight',
                    transitionIn: 'bounceInUp'
                });
            },
        }
    }
};

export default Msj;

/*const Msj = {
    info(titulo, mensaje) {
        iziToast.info({
            title: titulo,
            message: mensaje,
            position: 'topRight',
            transitionIn: 'bounceInUp'
        });
    }
}*/
