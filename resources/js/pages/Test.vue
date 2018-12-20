<template>
    <div class="px-10 pt-24">
        <iframe ref="editor" src="about:blank" class="w-full h-64 border shadow"></iframe>
    </div>
</template>

<script>
    const content = `
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <link rel="stylesheet" href="/css/formtech.css">
        </head>
        <body class="">

        <h2>test</h2>

        <blockquote>keks</blockquote>

        <button class="btn btn-primary btn-blue">asd</button>

        </body>
        </html>
    `;

    export default {
        name: '',


        mounted() {
            this.editor = this.$refs.editor;

            const doc = this.editor.contentWindow.document;
            doc.open();
            doc.writeln(content);

            doc.close();
        }
    }
</script>