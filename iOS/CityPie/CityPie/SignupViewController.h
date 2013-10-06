//
//  SignupViewController.h
//  CityPie
//
//  Created by Haifisch Laws on 10/6/13.
//  Copyright (c) 2013 Haifisch Laws. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface SignupViewController : UIViewController <NSURLConnectionDelegate,NSURLConnectionDataDelegate, UITextFieldDelegate>
@property (strong, nonatomic) IBOutlet UIButton *signUpButton;
- (IBAction)signMeUp:(id)sender;
@property (strong, nonatomic) IBOutlet UITextField *userName;
@property (strong, nonatomic) IBOutlet UITextField *userEmail;
@property (strong, nonatomic) IBOutlet UITextField *userPassword;
@property (strong, nonatomic) NSMutableData *responseData;
- (IBAction)cancel:(id)sender;
@end
