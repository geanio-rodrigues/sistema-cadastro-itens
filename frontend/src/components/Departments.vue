<script setup>
import {ref, onMounted} from 'vue';
import api from '../services/api';

const departments = ref([])
const loading = ref(false)
const error = ref(null)
const newName = ref('') // Estado para o input de criação
const editing = ref(null) // Estado para controlar qual item está em edição

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

// Função para remover um departamento
const removeDep = async (id) => {
    if (!confirm('Tem certeza que deseja excluir este departamento?')) return
    try {
        await api.delete(`/departments/${id}`)
        departments.value = departments.value.filter(d => d.id !== id)
    } catch (error) {
        error.value = 'Falha ao excluir o departamento.'
    }
}

// Funções de controle de edição
const startEdit = (dep) => { editing.value = { ...dep } } // Cria uma cópia para editar
const cancelEdit = () => { editing.value = null }
const saveEdit = async () => {
    if (!editing.value) return
    try {
        const { id, name } = editing.value
        const { data } = await api.put(`/departments/${id}`, { name })
        const index = departments.value.findIndex(d => d.id === id)
        if (index !== -1) {
            departments.value[index] = data
        }
        editing.value = null
    } catch (error) {
        error.value = 'Falha ao salvar. O nome pode já existir.'
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
                <template v-if="editing && editing.id === dep.id">
                    <input v-model="editing.name" @keyup.enter="saveEdit" @keyup.esc="cancelEdit" />
                    <div class="actions">
                        <button @click="saveEdit">Salvar</button>
                        <button @click="cancelEdit">Cancelar</button>
                    </div>
                </template>
                <template v-else>
                    <span>{{ dep.name }}</span>
                    <div class="actions">
                        <button @click="startEdit(dep)">Editar</button>
                        <button @click="removeDep(dep.id)">Excluir</button>
                    </div>
                </template>
            </li>
        </ul>
    </section>
</template>

<style scoped>
</style>