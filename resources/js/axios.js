// axios
import axios from 'axios'

axios.interceptors.request.use(function (config) {

  // sending json
  config.headers['Content-Type'] = 'application/json';
  config.headers.common['Content-Type'] = 'application/json';

  // return allways json
  config.headers['Accept'] = 'application/json';
  config.headers.common['Accept'] = 'application/json';

  return config;
});


export default axios
