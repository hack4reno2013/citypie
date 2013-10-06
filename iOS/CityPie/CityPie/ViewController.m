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
@synthesize chartView, menuView;
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
    
    NSString *urlAddress = @"http://citypie.us/stuff/WordSizer.php";
    NSURL *url = [NSURL URLWithString:urlAddress];
    NSURLRequest *requestObj = [NSURLRequest requestWithURL:url];
    [self.webView loadRequest:requestObj];
    self.navigationController.navigationBar.titleTextAttributes = @{UITextAttributeTextColor :[UIColor whiteColor], UITextAttributeFont: [UIFont fontWithName:@"GrandHotel" size:20]};
    self.revealButtonItem = [[UIBarButtonItem alloc] initWithImage:[UIImage imageNamed:@"menu_icon_white"] style:UIBarButtonItemStyleBordered target:self.revealViewController action:@selector(revealToggle:)];
    self.navigationItem.leftBarButtonItem = self.revealButtonItem;
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
    [self.pieChartLeft setPieCenter:CGPointMake(70, 73)];
    [self.pieChartLeft setUserInteractionEnabled:NO];
    self.pieChartLeft.showLabel = NO;
    self.sliceColors =[NSArray arrayWithObjects:[self colorFromHexString:@"#00A651"],[self colorFromHexString:@"#27AAE1"],[self colorFromHexString:@"#662D91"],[self colorFromHexString:@"#532516"],[self colorFromHexString:@"#FBB040"],[self colorFromHexString:@"#EF4136"], nil];

    chartView.backgroundColor = [UIColor colorWithRed:245/255.0f green:238/255.0f blue:228/255.0f alpha:1];
    menuView.backgroundColor = [UIColor colorWithRed:245/255.0f green:238/255.0f blue:228/255.0f alpha:1];
    
    [self.navigationController.navigationBar addGestureRecognizer: self.revealViewController.panGestureRecognizer];
    [self.navigationController.navigationBar setBarTintColor:[UIColor colorWithRed:49/255.0f green:49/255.0f blue:49/255.0f alpha:1]];
    [self setEdgesForExtendedLayout:UIRectEdgeNone];
}

-(void)viewDidAppear:(BOOL)animated{
    [super viewDidAppear:animated];
    [self.pieChartLeft reloadData];
}
-(IBAction)toggleLeftSlide:(id)sender {
    NSLog(@"Go...");
}
- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}
//Setup Menu
-(IBAction)showMenu:(id)sender{
    REMenuItem *allItem = [[REMenuItem alloc] initWithTitle:@"All"
                                                          image:nil
                                                         highlightedImage:nil
                                                         action:^(REMenuItem *item) {
                                                             NSLog(@"Item: %@", item);
                                                             self.catLabel.text = item.title;
                                                         }];
    REMenuItem *outdoorItem = [[REMenuItem alloc] initWithTitle:@"Outdoor"
                                                          image:[UIImage imageNamed:@"00A651"]
                                               highlightedImage:nil
                                                         action:^(REMenuItem *item) {
                                                             NSLog(@"Item: %@", item);
                                                             self.catLabel.text = item.title;
                                                         }];
    
    REMenuItem *industryItem = [[REMenuItem alloc] initWithTitle:@"Industry"
                                                           image:[UIImage imageNamed:@"27AAE1"]
                                                highlightedImage:nil
                                                          action:^(REMenuItem *item) {
                                                              NSLog(@"Item: %@", item);
                                                              self.catLabel.text = item.title;
                                                              
                                                          }];
    
    REMenuItem *volunteerItem = [[REMenuItem alloc] initWithTitle:@"Volunteer"
                                                            image:[UIImage imageNamed:@"662D91"]
                                                 highlightedImage:nil
                                                           action:^(REMenuItem *item) {
                                                               NSLog(@"Item: %@", item);
                                                               self.catLabel.text = item.title;
                                                               
                                                           }];
    
    REMenuItem *historyItem = [[REMenuItem alloc] initWithTitle:@"History"
                                                          image:[UIImage imageNamed:@"532516"]
                                               highlightedImage:nil
                                                         action:^(REMenuItem *item) {
                                                             NSLog(@"Item: %@", item);
                                                             self.catLabel.text = item.title;
                                                             
                                                         }];
    REMenuItem *foodItem = [[REMenuItem alloc] initWithTitle:@"Food"
                                                       image:[UIImage imageNamed:@"FBB040"]
                                            highlightedImage:nil
                                                      action:^(REMenuItem *item) {
                                                          NSLog(@"Item: %@", item);
                                                          self.catLabel.text = item.title;
                                                          
                                                      }];
    REMenuItem *entertainmentItem = [[REMenuItem alloc] initWithTitle:@"Entertainment"
                                                                image:[UIImage imageNamed:@"EF4136"]
                                                     highlightedImage:nil
                                                               action:^(REMenuItem *item) {
                                                                   NSLog(@"Item: %@", item);
                                                                   self.catLabel.text = item.title;
                                                                   
                                                                   
                                                               }];
    

    
    NSLog(@"%d", [self.menu isOpen]);
    
    if([self.menu  isOpen] == YES){
        [self.menu close];
        self.menu = nil;
    }else{
        self.menu = [[REMenu alloc] initWithItems:@[allItem,outdoorItem, industryItem, volunteerItem, historyItem, foodItem, entertainmentItem]];
        [self.menu showFromRect:CGRectMake(0, 197, 320, 420) inView:self.view];
        
    }
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


- (IBAction)reloadData:(id)sender {
    [self.webView reload];
}
@end
