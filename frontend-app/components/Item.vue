<template>
  <div class="idea">
    <span class="idea--text">{{ idea.text }}</span>

    <div class="idea--info">
      <div class="likes" @click="onLike(idea.id)">
        {{ idea.likes }}
      </div>
      <div class="dislikes" @click="onDislike(idea.id)">
        {{ idea.dislikes }}
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      idea: Object,
      onDislike: Function,
      onLike: Function
    }
  }
</script>

<style>
  .idea {
    display: flex;
    flex-direction: column;
    max-width: 400px;
    background-color: #fff;
    box-shadow: 0 2px 3px rgba(10,10,10,.1), 0 0 0 1px rgba(10,10,10,.1);
    color: #4a4a4a;
  }

  .idea--text {
    display: block;
    padding: 10px 20px;
    font-size: 16px;
    box-shadow: 0 1px 2px rgba(10,10,10,.1);
    line-height: 1.5;
    overflow-wrap: break-word;
    flex-grow: 1;
  }

  .idea--info {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    padding: 10px 20px;
  }
  
  .likes, .dislikes {
    padding-left: 25px;
    position: relative;
    cursor: pointer;
    color: #3273dc;
    user-select: none;
  }

  .likes:hover, .dislikes:hover {
    color: #363636;
  }

  .dislikes::before, .likes::before {
    display: block;
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
  }

  .likes::before {
    top: -5px;
    left: 0;
    background-image: url("./../images/thumb-up.png");
    background-size: contain;
  }

  .dislikes::before {
    top: 1px;
    left: 0;
    background-image: url("./../images/thumb-down.png");
    background-size: contain;
  }


</style>
