<script setup>
import { ref, onMounted } from 'vue';
import api from '../services/api';

const items = ref([])
const departments = ref([])
const loading = ref(false)
const error = ref(null)

// Funções para buscar departamentos e itens da API
const fetchItems = () => api.get('/items').then(response => (items.valu = response.data))
const fetchDeps = () => api.get('/departments').then(response => (departments.value = response.data))
const refresh = async () => {
    loading.value = true
    error.value = null
    try {
        await Promise.all([fetchItems(), fetchDeps()])
    } catch (error) {
        error.value = 'Falha ao carregar itens ou departamentos.'
    } finally {
        loading.value = false
    }
}

// Executa a busca assim que o componente for montado na tela
onMounted(refresh)

</script>

<template>
    <section>
        <h2>Itens</h2>
    </section>
</template>

<style scoped>
</style>