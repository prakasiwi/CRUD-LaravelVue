<template>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-8">
                <router-link 
                :to="{ name: 'transaksi.create'}"
                class="btn btn-primary btn-sm rounded shadow mb-3"
                >Add</router-link>

                <div class="card rounded shadow">
                    <div class="card-header">
                        Transaksi List
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(transaksi, index) in transaksis.data" :key="index">
                                    <td>{{transaksi.title}}</td>
                                    <td>{{transaksi.amount}}</td>
                                    <td>{{transaksi.type}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <router-link 
                                            :to="{ name: 'transaksi.edit', params:{id: transaksi.id}}"
                                            class="btn btn-sm btn-outline-info"
                                            >Edit</router-link>
                                            <button class="btn btn-sm btn-outline-danger"
                                                @click.prevent="destroy(transaksi.id, index)"
                                            >
                                                Delete   
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import {onMounted, ref} from 'vue'

export default {
    setup() {
        // reactive state
        let transaksis = ref([]);

        onMounted(() => {
            // get data from api endpoint
            axios.get('http://127.0.0.1:8000/api/transaksi')
            .then((result) => {
                transaksis.value = result.data
            }).catch((err) => {
                console.log(err.response)
            });
        });

        function destroy(id, index) {
            axios.delete(
                `http://127.0.0.1:8000/api/transaksi/${id}`
            )
            .then(() => {
                transaksis.value.data.splice(index, 1)
            }).catch((err) => {
                console.log(err.response.data);
            });
        }


        return {
            transaksis,
            destroy
        }
    }
}
</script>