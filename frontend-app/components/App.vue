<template>
  <div class="container">
    <idea--form :onSubmit="createIdea"></idea--form>

    <div class="idea--list">
      <idea--item v-for="idea in ideas"
                  :idea="idea"
                  :key="idea.id"
                  :onLike="like"
                  :onDislike="dislike"></idea--item>
    </div>
  </div>
</template>

<script>
  import Item from './Item'
  import Form from './Form'

  export default {
    components: {
      'idea--item': Item,
      'idea--form': Form
    },

    data () {
      return {
        ideas: []
      }
    },

    created () {
      this.fetchIdeas()
    },

    methods: {
      createIdea (text) {
        if (text.length === 0) {
          return
        }
        fetch('/api/ideas', {
          method: 'POST',
          body: JSON.stringify({
            text: text
          })
        })
          .then(() => {
            this.fetchIdeas()
          })
      },

      fetchIdeas () {
        fetch('/api/ideas')
          .then(response => response.json())
          .then(data => {
            this.ideas = data.ideas
          })
      },

      like (id) {
        fetch(`/api/like?id=${id}`, {
          method: 'POST'
        })
          .then(() => {
            this.fetchIdeas()
          })
      },

      dislike (id) {
        fetch(`/api/dislike?id=${id}`, {
          method: 'POST'
        })
          .then(() => {
            this.fetchIdeas()
          })
      }
    }
  }
</script>

<style>
  * {
    font-family: 'Roboto', sans-serif;
  }

  .container {
    max-width: 960px;
    margin: auto;
    padding: 20px 10px;
  }

  .idea--list {
    padding: 40px 0;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-gap: 20px;
  }

  @media (max-width: 800px) {
    .idea--list {
      grid-template-columns: 1fr 1fr;
    }
  }

  @media (max-width: 400px) {
    .idea--list {
      grid-template-columns: 1fr;
    }
  }
</style>
