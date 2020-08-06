import axios from 'axios';


const handler = {
    get(target, property) {
        if (['get', 'post', 'put'].includes(property)) {
            return (url, options) => {

                target.loading = true;

                if (typeof url === 'object' && url.hasOwnProperty('name')) {
                    url = route(url.name, url.params || {}).url()
                }

                return target.http[property](url, options).then(res => {
                    target.loading = false
                    return res
                }).catch(error => {
                    target.loading = false
                    throw error;
                })
            }
        }
        return target[property];
    }
}

export default class Api {

    constructor() {
        this.http = axios
        this.loading = false
        return new Proxy(this, handler)
    }


}

