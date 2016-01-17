<html>
    <head>
        <style>
            body {
                font-family: "Courier New", Courier, monospace;
            }
        </style>
    </head>
    <body>
        <?php echo ($this->info ?: $this->visualizer->getLastShotStatus()); ?>

        <br/>
        <pre><?php echo $this->visualizer->getFieldOutput(); ?></pre
        
        <br/>
        
        <form method="post" action="">
            <input type="text" size ="4" name="shot" />
            <input type="submit" />
        </form>
        
    </body>
</html>
