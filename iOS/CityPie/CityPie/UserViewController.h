//
//  UserViewController.h
//  CityPie
//
//  Created by Haifisch Laws on 10/5/13.
//  Copyright (c) 2013 Haifisch Laws. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "globals.h"
#import "AGMedallionView.h"
#import <QuartzCore/QuartzCore.h>
@interface UserViewController : UIViewController
@property(nonatomic, strong) NSMutableData *receivedData;
@property (strong, nonatomic) IBOutlet UIImageView *userImage;
@property (strong, nonatomic) IBOutlet AGMedallionView *medallionView;
@property (strong, nonatomic) IBOutlet UILabel *citiesLabel;
@property (strong, nonatomic) IBOutlet UILabel *checksLabel;
@property (strong, nonatomic) IBOutlet UILabel *bookmarksLabel;
@property (strong, nonatomic) IBOutlet UILabel *createdLabel;

@property (strong, nonatomic) IBOutlet UIView *userInfoView;
@property (strong, nonatomic) IBOutlet UIActivityIndicatorView *loadingIndicator;
@end
