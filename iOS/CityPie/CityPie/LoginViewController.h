//
//  LoginViewController.h
//  CityPie
//
//  Created by Haifisch Laws on 10/6/13.
//  Copyright (c) 2013 Haifisch Laws. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface LoginViewController : UIViewController
- (IBAction)login:(id)sender;
@property (strong, nonatomic) IBOutlet UIButton *logMeIn;
@property (strong, nonatomic) NSMutableData *responseData;
@property (strong, nonatomic) IBOutlet UITextField *userEmail;
@property (strong, nonatomic) IBOutlet UITextField *userPassword;

- (IBAction)cancle:(id)sender;

@end
