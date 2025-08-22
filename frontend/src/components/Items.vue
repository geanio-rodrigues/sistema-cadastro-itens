<script setup>
import { ref, onMounted } from 'vue';
import api from '../services/api';
import { CanceledError } from 'axios';

const items = ref([])
const departments = ref([])
const loading = ref(false)
const error = ref(null)
const form = ref({ name: '', department_id: '' }) // Estado para o formulário de criação
const editing = ref(null) // Estado para controlar a edição

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

// Função para remover um item
const removeItem = async (id) => {
    if (!confirm('Tem certeza que deseja excluir este item?')) return
    try {
        await api.delete(`/items/${id}`)
        items.value = items.value.filter(i => i.id !== id)
    } catch (error) {
        error.value = 'Falha ao executar o item.'
    }
}

// Funções de controle de edição
const startEdit = (item) => { editing.value = { ...item } }
const cancelEdit = () => { editing.value = null }
const saveEdit = async () => {
    if (!editing.value) return
    try {
        const { id, name, department_id } = editing.value
        const { data } = await api.put(`/items/${id}`, { name, department_id })
        const index = items.value.findIndex(i => i.id === id)
        if (index !== -1) {
            items.value[index] = data
        }
        editing.value = null
    } catch (error) {
        error.value = 'Falha ao salvar o item.'
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
        
        <ul>
            <li v-for="item in items" :key="item.id">
                <template v-if="editing && editing.id === item.id">
                    <input v-model="editing.name" />
                    <select v-model="editing.department_id">
                        <option v-for="d in departments" :key="d.id" :value="d.id">{{ d.name }}</option>
                    </select>
                    <div class="actions">
                        <button @click="saveEdit">Salvar</button>
                        <button @click="cancelEdit">Cancelar</button>
                    </div>
                </template>
                <template v-else>
                    <span>{{ item.name }} - <small>{{ item.department?.name }}</small></span>
                    <div class="actions">
                        <button @click="startEdit(item)">Editar</button>
                        <button @click="removeItem(item.id)">Excluir</button>
                    </div>
                </template>
            </li>
        </ul>
    </section>
</template>

<style scoped>
form {
    display: grid;
    grid-template-columns: 1fr 1fr auto;
    gap: .5rem;
    margin-bottom: 1rem;
}

form input, form select {
    padding: .5rem .75rem;
    border: 1px solid #ddd;
    border-radius: 8px;
}

button {
    border: 0;
    padding: .5rem 1rem;
    border-radius: 8px;
    cursor: pointer;
    background-color: #007bff;
    color: white;
}

button:hover {
    background-color: #0056b3;
}

ul {
    list-style: none;
    padding: 0;
    display: grid;
    gap: .5rem;
}

li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: 1px solid #eee;
    padding: .5rem .75rem;
    border-radius: 8px;
}

li small {
    color: #6c757d;
}

li input, li select {
    padding: .5rem .75rem;
    border: 1px solid #007bff;
    border-radius: 8px;
}

.actions {
    display: flex;
    gap: .5rem;
}

.actions button {
    background-color: #6c757d;
}

.actions button:hover {
    background-color: #5a6268;
}
</style>