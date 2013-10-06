//
//  UserViewController.m
//  CityPie
//
//  Created by Haifisch Laws on 10/5/13.
//  Copyright (c) 2013 Haifisch Laws. All rights reserved.
//

#import "UserViewController.h"

@interface UserViewController ()

@end

@implementation UserViewController
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
    self.revealButtonItem = [[UIBarButtonItem alloc] initWithImage:[UIImage imageNamed:@"menu_icon_white"] style:UIBarButtonItemStyleBordered target:self.revealViewController action:@selector(revealToggle:)];
    self.navigationItem.leftBarButtonItem = self.revealButtonItem;
    self.navigationController.navigationBar.titleTextAttributes = @{UITextAttributeTextColor :[UIColor whiteColor], UITextAttributeFont: [UIFont fontWithName:@"Helvetica" size:20]};
    NSNumber *entertainment = [NSNumber numberWithInt:10];
    NSNumber *outdoor = [NSNumber numberWithInt:20];
    NSNumber *industry = [NSNumber numberWithInt:30];
    
    NSArray *objects= [[NSArray alloc] initWithObjects:entertainment,outdoor,industry, nil];
    [_slices addObjectsFromArray:objects];
    [super viewDidLoad];
    [self loadData];
    //self.userImage.layer.cornerRadius = self.u.size.width / 2;
    //self.userImage.layer.masksToBounds = YES;
    self.userInfoView.backgroundColor = [UIColor colorWithRed:245/255.0f green:238/255.0f blue:228/255.0f alpha:1];
    self.menuView.backgroundColor = [UIColor colorWithRed:245/255.0f green:238/255.0f blue:228/255.0f alpha:1];
    [self.userInfoView setHidden:YES];
    [self.menuView setHidden:YES];
    [self.loadingIndicator startAnimating];
    [self.pieChartLeft setDataSource:self];
    //[self.pieChartLeft setStartPieAngle:M_PI_2];
    [self.pieChartLeft setAnimationSpeed:1.0];
    [self.pieChartLeft setShowPercentage:NO];
    [self.pieChartLeft setPieBackgroundColor:[UIColor colorWithRed:245/255.0f green:238/255.0f blue:228/255.0f alpha:1]];
    [self.pieChartLeft setPieCenter:CGPointMake(15, 15)];
    [self.pieChartLeft setUserInteractionEnabled:NO];
    self.pieChartLeft.showLabel = NO;
    self.sliceColors =[NSArray arrayWithObjects:[self colorFromHexString:@"#00A651"],[self colorFromHexString:@"#27AAE1"],[self colorFromHexString:@"#662D91"],[self colorFromHexString:@"#532516"],[self colorFromHexString:@"#FBB040"],[self colorFromHexString:@"#EF4136"], nil];
    [self.navigationController.navigationBar addGestureRecognizer: self.revealViewController.panGestureRecognizer];
    [self.navigationController.navigationBar setBarTintColor:[UIColor colorWithRed:49/255.0f green:49/255.0f blue:49/255.0f alpha:1]];
    [self setEdgesForExtendedLayout:UIRectEdgeNone];

}
// Nav back
- (void) popVC{
    [self.navigationController popViewControllerAnimated:YES];
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
    
    
    NSLog(@"%@", self.menu);
    if([self.menu  isOpen] == YES){
        [self.menu close];
        self.menu = nil;
    }else{
        self.menu = [[REMenu alloc] initWithItems:@[allItem, outdoorItem, industryItem, volunteerItem, historyItem, foodItem, entertainmentItem]];
        [self.menu showFromRect:CGRectMake(0, 206, 320, 420) inView:self.view];
    }
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}
-(void) loadData {
    
    NSLog(@"loadData...");
    self.receivedData = [[NSMutableData alloc] init];
    NSURL *url = [NSURL URLWithString:[NSString stringWithFormat:@"%@%@",API_USER, USER_ID]];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL: url cachePolicy: NSURLRequestUseProtocolCachePolicy timeoutInterval: 360.0];
    [NSURLConnection connectionWithRequest:request delegate:self];
    
}


-(void)connection:(NSURLConnection *)connection didReceiveResponse:(NSURLResponse *)response {
    NSLog(@"didReceiveResponse...");
    [self.receivedData setLength:0];
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data {
    NSLog(@"didReceiveData...");
    NSLog(@"Succeeded! Received %ld bytes of data",(unsigned long)[data length]);
    [self.receivedData appendData:data];
    
}

- (void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error {
    NSLog(@"didFailWithError...");
    NSLog(@"Connection failed! Error - %@ %@",[error localizedDescription],[[error userInfo] objectForKey:NSURLErrorFailingURLStringErrorKey]);
    //lblError.text = [NSString stringWithFormat:@"Connection failed! Error - %@",[error localizedDescription]];
    self.receivedData = nil;
}


-(void) connectionDidFinishLoading:(NSURLConnection *)connection {
    [self.loadingIndicator stopAnimating];
    [self.userInfoView setHidden:NO];
    [self.menuView setHidden:NO];
    NSLog(@"connectionDidFinishLoading...");
    NSError *error = nil;
    //id result = [NSJSONSerialization JSONObjectWithData:self.receivedData options:kNilOptions error:&error];
    NSDictionary *jsonData = [NSJSONSerialization JSONObjectWithData:self.receivedData options:kNilOptions error:&error];
    self.title = [[jsonData objectForKey:@"data"] objectForKey:@"name"];
   // self.userImage = [[jsonData objectForKey:@"data"] objectForKey:@"pic"];
    NSURL * imageURL = [NSURL URLWithString:[NSString stringWithFormat:@"%@%@", BASE, [[jsonData objectForKey:@"data"] objectForKey:@"pic"]]];
    NSData * imageData = [NSData dataWithContentsOfURL:imageURL];
    UIImage * image = [UIImage imageWithData:imageData];
    self.medallionView = [[AGMedallionView alloc] initWithFrame:CGRectMake(10, 10, 135, 140)];
    self.medallionView.image = image;
    [self.userInfoView addSubview:self.medallionView];
    self.citiesLabel.text = [NSString stringWithFormat:@"%i",[[[jsonData objectForKey:@"data"] objectForKey:@"cities"] integerValue]];
    self.checksLabel.text = [NSString stringWithFormat:@"%i",[[[jsonData objectForKey:@"data"] objectForKey:@"checks"] integerValue]];
    self.bookmarksLabel.text = [NSString stringWithFormat:@"%i",[[[jsonData objectForKey:@"data"] objectForKey:@"bookmarks"] integerValue] ];
    double unixTimeStamp = [[[jsonData objectForKey:@"data"] objectForKey:@"created"] doubleValue];
    NSTimeInterval _interval=unixTimeStamp;
    NSDate *date = [NSDate dateWithTimeIntervalSince1970:_interval];
    NSDateFormatter *_formatter=[[NSDateFormatter alloc]init];
    [_formatter setLocale:[NSLocale currentLocale]];
    [_formatter setDateFormat:@"dd.MM.yyyy"];
    NSString *_date=[_formatter stringFromDate:date];
    self.createdLabel.text = _date;
    /*if (error) {
        NSLog(@"%@",error.localizedDescription);
        NSLog(@"%@",[[NSString alloc] initWithData:self.receivedData encoding:NSUTF8StringEncoding]);
    }else{
        NSLog(@"Finished...Download/Parsing successful");
        NSLog(@"%@", result);
        
        if ([result isKindOfClass:[NSArray class]])
            NSLog(@"%@",result);
    }*/
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
