//
//  UserViewController.h
//  CityPie
//
//  Created by Haifisch Laws on 10/5/13.
//  Copyright (c) 2013 Haifisch Laws. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "globals.h"
#import <QuartzCore/QuartzCore.h>
@interface UserViewController : UIViewController
@property(nonatomic, strong) NSMutableData *receivedData;
@property (strong, nonatomic) IBOutlet UIImageView *userImage;

@property (strong, nonatomic) IBOutlet UIView *userInfoView;
@end
