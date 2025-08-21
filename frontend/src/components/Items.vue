<script setup>
import { ref, onMounted } from 'vue';
import api from '../services/api';

const items = ref([])
const departments = ref([])
const loading = ref(false)
const error = ref(null)
const form = ref({ name: '', department_id: '' }) // Estado para o formulário de criação

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

// Função para criar um novo item
const createItem = async () => {
    if (!form.value.name.trim() || !form.value.department_id) return
    try {
        const { data } = await api.post('/items', form.value)
        items.value.push(data) // Adiciona o novo item à lista
        form.value = { name: '', department_id: '' } // Limpa o formulário
        error.value = null
    } catch (error) {
        error.value = 'Falha ao criar o item.'
    }
}

</script>

<template>
    <section>
        <h2>Itens</h2>
        <p v-if="loading">Carrgando...</p>
        <p v-if="error" style="color:red">{{  error }}</p>

        <form @submit.prevent="createItem">
            <input v-model="form.name" placeholder="Nome do novo item" required />
            <select v-model="form.department_id" required>
                <option disabled value="">Selecione o departamento</option>
                <option v-for="d in departments" :key="d.id" :value="d.id">{{ d.name }}</option>
            </select>
            <button type="submit">Adicionar</button>
        </form>

    </section>
</template>

<style scoped>
</style>