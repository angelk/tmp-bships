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
            Enter coordinates (row, col), e.g. A5
            <input type="text" size ="4" name="shot" autofocus=""/>
            <input type="submit" />
        </form>
        
    </body>
</html>
