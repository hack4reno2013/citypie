//
//  SuperSecretSettingsViewController.h
//  CityPie
//
//  Created by Haifisch on 10/14/13.
//  Copyright (c) 2013 Haifisch Laws. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface SuperSecretSettingsViewController : UIViewController {
    NSUserDefaults *storage;
}
@property (strong, nonatomic) IBOutlet UILabel *userID;

@property (strong, nonatomic) IBOutlet UITextField *newtUserID;
- (IBAction)done:(id)sender;
- (IBAction)setID:(id)sender;

@end
