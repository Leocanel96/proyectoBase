// Vuetify
import 'vuetify/styles'
import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-
import {createVuetify} from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import {VDataTable} from 'vuetify/labs/VDataTable'

const vuetify = createVuetify({
    components,
    directives,
    VDataTable
})

export default vuetify
