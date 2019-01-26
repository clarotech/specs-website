<?php
    /**
     * GIT DEPLOYMENT SCRIPT
     *
     */

    // The commands
    $commands = array(
        'echo $PWD',
        'whoami',
        'git pull',
        'git log -n 3',
        'git --work-tree=%work_tree% checkout -f ',
    	'git status',
        'chmod ug+x %site_root%/scripts/*.sh'
    );

    // Run the commands for output
    $output = '';

	// get directory like /var/www/vhosts/openehr.org/specifications.openehr.org
    $site_root = getcwd();
    $work_tree = dirname (getcwd());

	// get site_name like specifications.openehr.org
    $site_name = basename ($work_tree);

	// determine repo location as /var/www/git/specifications.openehr.org
    $repodir = "/var/www/git/" . $site_name;
    chdir ($repodir);

    $output .= "chdir (" . $repodir . ")\n";

    foreach ($commands AS $command){

        $cmd_str = str_replace ("%work_tree%", $work_tree, $command);
        $cmd_str = str_replace ("%site_root%", $site_root, $command);

        // Run it
        $tmp = shell_exec($cmd_str);
        // Output
        $output .= "--- {$cmd_str} ---\n";
        $output .= htmlentities(trim($tmp)) . "\n";
    }
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>GIT DEPLOYMENT SCRIPT</title>
</head>
<body style="background-color: #000000; color: #FFFFFF; font-weight: bold; padding: 0 10px;">
<pre>
<?php echo $output; ?>
</pre>
</body>
</html> 
