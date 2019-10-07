<template>
    <div class="container">
        <question :question-model="questionModel"></question>
        <answers :question-model="questionModel"></answers>
    </div>
</template>

<script>
    import Question from '../components/Question.vue';
    import Answers from '../components/Answers.vue';

    export default {
        name: "QuestionPage",

        props: ['questionModel'],

        components: {
            Question,
            Answers
        }
    }
</script>
