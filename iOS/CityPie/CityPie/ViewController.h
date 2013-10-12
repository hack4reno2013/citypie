//
//  ViewController.h
//  CityPie
//
//  Created by Haifisch Laws on 10/5/13.
//  Copyright (c) 2013 Haifisch Laws. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "XYPieChart.h"
#import "MenuViewController.h"
#import "REMenu.h"
#import "SVGKit.h"
@interface ViewController : UIViewController <XYPieChartDataSource, XYPieChartDelegate>{
}
- (IBAction)reloadData:(id)sender;
@property (strong, nonatomic) IBOutlet UIBarButtonItem *revealButtonItem;
@property (strong, nonatomic) IBOutlet UIView *chartView;
@property (strong, nonatomic) IBOutlet UIView *menuView;
@property (strong, nonatomic) IBOutlet UIWebView *webView;
@property (strong, nonatomic) IBOutlet XYPieChart *pieChartLeft;
@property (strong,nonatomic) IBOutlet UIBarButtonItem *leftNavItem;
@property(nonatomic, strong) REMenu *menu;
@property(nonatomic, strong) NSMutableArray *slices;
@property(nonatomic, strong) NSArray        *sliceColors;
-(IBAction)toggleLeftSlide:(id)sender;
-(IBAction)showMenu:(id)sender;
@property (strong, nonatomic) IBOutlet UIButton *menuButton;
@property (strong, nonatomic) IBOutlet UILabel *catLabel;
@end
