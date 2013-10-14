//
//  SuperSecretSettingsViewController.m
//  CityPie
//
//  Created by Haifisch on 10/14/13.
//  Copyright (c) 2013 Haifisch Laws. All rights reserved.
//

#import "SuperSecretSettingsViewController.h"

@interface SuperSecretSettingsViewController ()

@end

@implementation SuperSecretSettingsViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    storage = [NSUserDefaults standardUserDefaults];
    
    self.userID.text = [NSString stringWithFormat:@"usrID = %@", [storage objectForKey:@"user_id"]];
    NSLog(@"%@", [storage objectForKey:@"user_id"]);
	// Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (IBAction)done:(id)sender {
    [self dismissViewControllerAnimated:YES completion:nil];
}

- (IBAction)setID:(id)sender {
    [storage setObject:self.newtUserID.text forKey:@"user_id"];
    self.userID.text = [storage objectForKey:@"user_id"];
    UIAlertView *confirmation = [[UIAlertView alloc] initWithTitle:@"Done" message:[NSString stringWithFormat:@"user_id is now %@", [storage objectForKey:@"user_id"]] delegate:self cancelButtonTitle:@"Ok" otherButtonTitles: nil];
    [confirmation show];
}
@end
