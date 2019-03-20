<template>
  <form class="form" @submit.prevent="onSubmit(text)">
    <input v-model="text" class="form--input" placeholder="e.g. Cool app!" required>
    <button class="form--button">Suggest</button>
  </form>
</template>

<script>
  export default {
    props: {
      onSubmit: Function
    },
    data () {
      return {
        text: ''
      }
    }
  }
</script>

<style>
  .form {
    display: flex;
    justify-content: center;
    justify-items: center;
  }

  .form--input {
    box-sizing: border-box;
    padding: 10px;
    flex-grow: 1;
    background-color: #fff;
    color: #363636;
    border: 1px solid #dbdbdb;
    box-shadow: inset 0 1px 2px rgba(10, 10, 10, .1);
    outline: none;
  }

  .form--input:hover {
    border-color: #b5b5b5;
  }

  .form--input:active, .form--input:focus, .form--button:hover, .form--button:active, .form--button:focus {
    border-color: #4a4a4a;
    color: #363636;
  }
  
  .form--button {
    padding: 0 10px;
    background-color: #fff;
    border: 1px solid #dbdbdb;
    color: #363636;
    text-align: center;
    white-space: nowrap;
    cursor: pointer;
    outline: none;
  }
</style>
