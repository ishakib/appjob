import './bootstrap';
import { createApp } from 'vue';
import 'vue3-easy-data-table/dist/style.css';
import JobPost from './components/JobPost.vue';

const app = createApp({});
app.component('job-post', JobPost);
app.mount('#app');
