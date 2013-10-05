//
//  ViewController.h
//  CityPie
//
//  Created by Haifisch Laws on 10/5/13.
//  Copyright (c) 2013 Haifisch Laws. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "XYPieChart.h"
#import "IIViewDeckController.h"
#import "MenuViewController.h"
@interface ViewController : UIViewController <XYPieChartDataSource, XYPieChartDelegate>{
}
@property (strong, nonatomic) IBOutlet UIView *chartView;
@property (strong, nonatomic) IBOutlet XYPieChart *pieChartLeft;
@property (strong,nonatomic) IBOutlet UIBarButtonItem *leftNavItem;
@property(nonatomic, strong) NSMutableArray *slices;
@property(nonatomic, strong) NSArray        *sliceColors;
-(IBAction)toggleLeftSlide:(id)sender;

@end
