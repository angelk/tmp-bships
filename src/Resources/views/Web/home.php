<html>
    <head>
        <style>
            body {
                font-family: "Courier New", Courier, monospace;
            }
        </style>
    </head>
    <body>
        twig home

        <br/>

        <?php echo $this->visualizer->getLastShotStatus(); ?>

        <br/>
        <pre><?php echo $this->visualizer->getFieldOutput(); ?></pre
    </body>
</html>
