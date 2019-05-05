# Simple PHP Project Which Will Automatically Take Snapshot Every Hour And Delete Old One For DigitalOcean 


###### Requirement

You will need valid DigitalOcean Token

You will need valid DigitalOcean Droplet ID

You will need to delete all current snapshots which is taken manually or using any other script or software program


###### Cronjob instruction

You can use Crontab if you are using linux or you can use cronjob if you are using cPanel or there is another site for setting up cron jobs free of cost

https://cron-job.org/en/

You need to execute snapshot_automation.php file every minute or whatever frequency you like.

I recommend using cron frequency of 10 minutes because for larger droplets it may take sometime to create snapshot.


###### Source:
https://www.ekreative.com/digital-ocean-api-daily-backups/

https://github.com/ishan3350/DigitalOceanSimpleSnapshotAPI

Thank you very much