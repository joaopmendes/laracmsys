import ReactDOM from "react-dom";
import React from "react";
import Homepage from "./pages/Homepage";
import axios from 'axios';

require('./bootstrap');
// Bring reducers
//Bring routes
axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content')
axios.defaults.headers.post['xsrfCookieName'] = 'CSRFToken';
axios.defaults.headers.post['xsrfHeaderName'] = 'X-CSRFToken';
axios.defaults.headers.post['responseType'] = 'json';
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
const App = () => {

};

if (document.getElementById('root')) {
    ReactDOM.render(<Homepage/>, document.getElementById('root'));
}
