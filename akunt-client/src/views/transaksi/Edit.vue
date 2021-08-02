<template>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-8">
                <router-link 
                :to="{ name: 'transaksi.index'}"
                class="btn btn-primary btn-sm rounded shadow mb-3"
                >Back</router-link>

                <div class="card rounded shadow">
                    <div class="card-header">
                        Edit Transaksi
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="update()">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" v-model="transaksi.title">
                                <div v-if="validation.title" class="text-danger">
                                    {{ validation.title[0] }}
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Amount</label><br>
                                <input type="number" class="form-control" v-model="transaksi.amount">
                                <div v-if="validation.amount" class="text-danger">
                                    {{ validation.amount[0] }}
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Time</label>
                                <input type="text" class="form-control" placeholder="yyyy-mm-dd hh-mm-ss" v-model="transaksi.time">
                                <div v-if="validation.time" class="text-danger">
                                    {{ validation.time[0] }}
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Type</label>
                                <select id="" class="form-select" v-model="transaksi.type">
                                    <option value="expense">Expense</option>
                                    <option value="revenue">Revenue</option>
                                </select>
                                <div v-if="validation.type" class="text-danger">
                                    {{ validation.type[0] }}
                                </div>
                            </div>
                            <button class="btn btn-outline-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import axios from 'axios'

export default {
    setup() {
        // data binding
        let transaksi = reactive({
            title: '',
            amount: '',
            time: '',
            type: '',
        });

        const validation = ref([]);

        const router = useRouter();
        const route = useRoute();

        onMounted(() => {
           axios.get(`http://127.0.0.1:8000/api/transaksi/${route.params.id}`)
           .then((result) => {
               transaksi.title = result.data.data.title
               transaksi.amount = result.data.data.amount
               transaksi.time = result.data.data.time
               transaksi.type = result.data.data.type
           }).catch((err) => {
               console.log(err.response.data)
           }); 
        });

        function update() {
            axios.put(
                `http://127.0.0.1:8000/api/transaksi/${route.params.id}`,
                transaksi
            )
            .then(() => {
                router.push({
                    name: 'transaksi.index'
                });
            }).catch((err) => {
                validation.value = err.response.data
            });
        }

        return {
            transaksi,
            validation,
            router,
            update
        }
    }
}
</script>