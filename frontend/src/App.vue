<script setup>
// App "shell": injeta os módulos de CRUD
import Departments from './components/Departments.vue';
import Items from './components/Items.vue';
</script>

<template>
  <main>
    <h1>Sistema de Cadastro</h1>
    <Departments />
    <hr />
    <Items />
  </main>
</template>

<style scoped>
/* Estilos globais para a página */
body {
  font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  margin: 0;
  background: #f5f6f8;
}

main {
  max-width: 900px;
  margin: 2rem auto;
  background: #fff;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, .06);
}

h1 {
  text-align: center;
  margin: 0 0 2rem;
  color: #333;
}

hr {
  border: none;
  border-top: 1px solid #eee;
  margin: 2rem 0;
}
</style>
