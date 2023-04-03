        <?php if (!empty($copyright) || !empty($content)): ?>
        <table border="0" width="100%" style="font-size: 12px; font-family: arial;">
            <tr>
                <?php if (!empty($copyright)): ?>
                <td style="text-align: left"><p><br><?php echo $copyright; ?></p></td>
                <?php endif; ?>
                <?php if (!empty($content)): ?>
                <td style="text-align: right;"><p><br><strong><?php echo $content; ?></p></td>
                <?php endif; ?>
            </tr>
        </table>
        <?php endif; ?>
    </body>
</html>