//
//  ViewController.m
//  CityPie
//
//  Created by Haifisch Laws on 10/5/13.
//  Copyright (c) 2013 Haifisch Laws. All rights reserved.
//

#import "ViewController.h"

@interface ViewController ()

@end

@implementation ViewController
@synthesize chartView;
// UIColor from hex, pretty much
- (UIColor *)colorFromHexString:(NSString *)hexString {
    unsigned rgbValue = 0;
    NSScanner *scanner = [NSScanner scannerWithString:hexString];
    [scanner setScanLocation:1]; // bypass '#' character
    [scanner scanHexInt:&rgbValue];
    return [UIColor colorWithRed:((rgbValue & 0xFF0000) >> 16)/255.0 green:((rgbValue & 0xFF00) >> 8)/255.0 blue:(rgbValue & 0xFF)/255.0 alpha:1.0];
}
- (void)viewDidLoad
{
    self.slices = [NSMutableArray arrayWithCapacity:10];
    
    NSNumber *entertainment = [NSNumber numberWithInt:10];
    NSNumber *outdoor = [NSNumber numberWithInt:20];
    NSNumber *industry = [NSNumber numberWithInt:30];
    NSNumber *volunteer = [NSNumber numberWithInt:10];
    NSNumber *history = [NSNumber numberWithInt:5];
    NSNumber *food = [NSNumber numberWithInt:25];

    NSArray *objects= [[NSArray alloc] initWithObjects:entertainment,outdoor,industry,volunteer,history,food, nil];
        [_slices addObjectsFromArray:objects];
    
    [super viewDidLoad];
    self.title = @"Reno, NV"; // to be changed by API 
   // [self.navigationController.navigationBar setBarTintColor:[UIColor colorWithRed:1/255.0f green:1/255.0f blue:1/255.0f alpha:1]];
    //UIBarButtonItem *navMore = [[UIBarButtonItem alloc] init];
    //navMore.image = [UIImage imageNamed:@""];
    [self.pieChartLeft setDataSource:self];
    //[self.pieChartLeft setStartPieAngle:M_PI_2];
    [self.pieChartLeft setAnimationSpeed:1.0];
    [self.pieChartLeft setShowPercentage:NO];
    [self.pieChartLeft setPieBackgroundColor:[UIColor colorWithRed:245/255.0f green:238/255.0f blue:228/255.0f alpha:1]];
    [self.pieChartLeft setPieCenter:CGPointMake(70, 87)];
    [self.pieChartLeft setUserInteractionEnabled:NO];
    self.pieChartLeft.showLabel = NO;
    self.sliceColors =[NSArray arrayWithObjects:[self colorFromHexString:@"#00A651"],[self colorFromHexString:@"#27AAE1"],[self colorFromHexString:@"#662D91"],[self colorFromHexString:@"#532516"],[self colorFromHexString:@"#FBB040"],[self colorFromHexString:@"#EF4136"], nil];

    chartView.backgroundColor = [UIColor colorWithRed:245/255.0f green:238/255.0f blue:228/255.0f alpha:1];
    
    //UIBarButtonItem *leftButton = [[UIBarButtonItem alloc] initWithImage:<#(UIImage *)#> style:<#(UIBarButtonItemStyle)#> target:<#(id)#> action:<#(SEL)#>];
   // self.navigationItem.leftBarButtonItem = [[UIBarButtonItem alloc] initWithTitle:@"<" style:UIBarButtonItemStyleBordered target:self.viewDeckController action:@selector(toggleLeftView)];
    self.leftNavItem = [[UIBarButtonItem alloc] init];
    self.leftNavItem.image = [UIImage imageNamed:@"menu_icon_white.png"];
    [self.leftNavItem setTarget:self];
    [self.leftNavItem setAction:@selector(toggleLeftSlide:)];
    [self.leftNavItem setTintColor:[UIColor whiteColor]];
    self.navigationItem.leftBarButtonItem = self.leftNavItem;
}
-(void)viewDidAppear:(BOOL)animated{
    [super viewDidAppear:animated];
    [self.pieChartLeft reloadData];
}
-(IBAction)toggleLeftSlide:(id)sender {
    [self.viewDeckController toggleOpenView];
}
- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}
// JSON download, and parse!
-(void)parsejson{
    
}

#pragma mark - XYPieChart Data Source

- (NSUInteger)numberOfSlicesInPieChart:(XYPieChart *)pieChart
{
    return self.slices.count;
}

- (CGFloat)pieChart:(XYPieChart *)pieChart valueForSliceAtIndex:(NSUInteger)index
{
    return [[self.slices objectAtIndex:index] intValue];
}

- (UIColor *)pieChart:(XYPieChart *)pieChart colorForSliceAtIndex:(NSUInteger)index
{
    return [self.sliceColors objectAtIndex:(index % self.sliceColors.count)];
}

#pragma mark - XYPieChart Delegate
- (void)pieChart:(XYPieChart *)pieChart willSelectSliceAtIndex:(NSUInteger)index
{
    NSLog(@"will select slice at index %d",index);
}
- (void)pieChart:(XYPieChart *)pieChart willDeselectSliceAtIndex:(NSUInteger)index
{
    NSLog(@"will deselect slice at index %d",index);
}
- (void)pieChart:(XYPieChart *)pieChart didDeselectSliceAtIndex:(NSUInteger)index
{
    NSLog(@"did deselect slice at index %d",index);
}
- (void)pieChart:(XYPieChart *)pieChart didSelectSliceAtIndex:(NSUInteger)index
{
    NSLog(@"did select slice at index %d",index);
}


@end
