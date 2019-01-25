<?php
    /**
     * GIT DEPLOYMENT SCRIPT
     *
     * Used for automatically deploying websites via github or bitbucket, more deets here:
     *
     *        https://gist.github.com/1809044
     */

    // The commands
    $commands = array(
        'echo $PWD',
        'whoami',
        'git pull',
        'git log -n 3',
        'git --work-tree=%worktree% checkout -f ',
        'git status'
    );

    // Run the commands for output
    $output = '';

	// get directory like /var/www/vhosts/openehr.org/specifications.openehr.org
    $worktree = dirname (getcwd());

	// get sitename like specifications.openehr.org
    $sitename = basename ($worktree);

	// determine repo location as /var/www/git/specifications.openehr.org
    $repodir = "/var/www/git/" . $sitename;
    chdir ($repodir);

    $output .= "chdir (" . $repodir . ")\n";

    foreach ($commands AS $command){

        $cmd_str = str_replace ("%worktree%", $worktree, $command);

        // Run it
        $tmp = shell_exec($cmd_str);
        // Output
        $output .= "<span style=\"color: #6BE234;\">\$</span> <span style=\"color: #729FCF;\">{$cmd_str}\n</span>";
        $output .= htmlentities(trim($tmp)) . "\n";
    }

    // Make it pretty for manual user access (and why not?)
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>GIT DEPLOYMENT SCRIPT</title>
</head>
<body style="background-color: #000000; color: #FFFFFF; font-weight: bold; padding: 0 10px;">
<pre>
 .  ____  .    ____________________________
 |/      \|   |                            |
[| <span style="color: #FF0000;">&hearts;    &hearts;</span> |]  | Git Deployment Script v0.1 |
 |___==___|  /              &copy; oodavid 2012 |
              |____________________________|

<?php echo $output; ?>
</pre>
</body>
</html> 
