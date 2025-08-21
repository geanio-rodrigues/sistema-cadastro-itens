<script setup>
import {ref, onMounted} from 'vue';
import api from '../services/api';

const departments = ref([])
const loading = ref(false)
const error = ref(null)
const newName = ref('') // Estado para o input de criação

// Função para buscar todos os departamentos da API
const fetchAll = async () => {
    loading.value = true
    error.value = true
    try {
        const { data } = await api.get('/departments')
        departments.value = data
    } catch (error) {
        error.value = 'Falha ao carregar departamentos.'
    } finally {
        loading.value = false
    }
}

// Executa a busca assim que o componente for montado na tela
onMounted(fetchAll)

// Função para criar um novo departamento
const createDep = async () => {
    if (!newName.value.trim()) return
    try {
        const { data } = await api.post('/departments', { name: newName.value })
        departments.value = '' // Limpa o input
        error.value = null
    } catch (error) {
        error.value = 'Não foi possível criar. O departamento pode já existir.'
    }
}
</script>

<template>
    <section>
        <h2>Departamentos</h2>
        <p v-if="loading">Carregando...</p>
        <p v-if="error" style="color:red">{{ error }}</p>

        <form @submit.prevent="createDep">
            <input v-model="newName" placeholder="Nome do novo departamento" required />
            <button type="submit">Adicionar</button>
        </form>

        <ul>
            <li v-for="dep in departments" :key="dep.id">
                <span>{{ dep.name }}</span>
            </li>
        </ul>
    </section>
</template>

<style scoped>
</style>