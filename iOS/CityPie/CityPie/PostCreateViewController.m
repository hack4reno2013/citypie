//
//  PostCreateViewController.m
//  CityPie
//
//  Created by Haifisch Laws on 10/6/13.
//  Copyright (c) 2013 Haifisch Laws. All rights reserved.
//

#import "PostCreateViewController.h"

@interface PostCreateViewController ()

@end

@implementation PostCreateViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    NSString *urlAddress = @"http://citypie.us/task/add";
    NSURL *url = [NSURL URLWithString:urlAddress];
    NSURLRequest *requestObj = [NSURLRequest requestWithURL:url];
    [self.webView loadRequest:requestObj];
    self.view.backgroundColor = [UIColor colorWithRed:245/255.0f green:238/255.0f blue:228/255.0f alpha:1];
    self.title = @"Create Task";
    UIImage *menuImage = [SVGKImage imageNamed:@"menu_icon.svg"].UIImage;
    self.revealButtonItem = [[UIBarButtonItem alloc] initWithImage:menuImage style:UIBarButtonItemStyleBordered target:self.revealViewController action:@selector(revealToggle:)];
    self.navigationItem.leftBarButtonItem = self.revealButtonItem;
    self.navigationController.navigationBar.titleTextAttributes = @{UITextAttributeTextColor :[UIColor whiteColor], UITextAttributeFont: [UIFont fontWithName:@"Helvetica" size:20]};
    self.revealButtonItem.tintColor = [UIColor whiteColor];
    [self.navigationController.navigationBar addGestureRecognizer:self.revealViewController.panGestureRecognizer];
    [self.navigationController.navigationBar setBarTintColor:[UIColor colorWithRed:49/255.0f green:49/255.0f blue:49/255.0f alpha:1]];
    [self setEdgesForExtendedLayout:UIRectEdgeNone];
    [self.view addGestureRecognizer:self.revealViewController.panGestureRecognizer];

}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
