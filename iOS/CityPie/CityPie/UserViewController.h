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
#import "XYPieChart.h"
#import "REMenu.h"
@interface UserViewController : UIViewController <XYPieChartDataSource,XYPieChartDelegate>
@property (strong, nonatomic) IBOutlet UIBarButtonItem *revealButtonItem;

@property(nonatomic, strong) NSMutableData *receivedData;
@property (strong, nonatomic) IBOutlet UIImageView *userImage;
@property (strong, nonatomic) IBOutlet AGMedallionView *medallionView;
@property (strong, nonatomic) IBOutlet UILabel *citiesLabel;
@property (strong, nonatomic) IBOutlet UILabel *checksLabel;
@property (strong, nonatomic) IBOutlet UILabel *bookmarksLabel;
@property (strong, nonatomic) IBOutlet UILabel *createdLabel;
@property(nonatomic, strong) NSMutableArray *slices;
@property(nonatomic, strong) NSArray        *sliceColors;
@property (strong, nonatomic) IBOutlet UIView *userInfoView;
@property (strong, nonatomic) IBOutlet XYPieChart *pieChartLeft;
@property (strong, nonatomic) IBOutlet UIView *menuView;
@property (strong, nonatomic) IBOutlet UIActivityIndicatorView *loadingIndicator;
@property (strong, nonatomic) IBOutlet UILabel *catLabel;
@property(nonatomic, strong) REMenu *menu;
-(IBAction)showMenu:(id)sender;
@end
