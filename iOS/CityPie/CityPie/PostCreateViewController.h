//
//  PostCreateViewController.h
//  CityPie
//
//  Created by Haifisch Laws on 10/6/13.
//  Copyright (c) 2013 Haifisch Laws. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface PostCreateViewController : UIViewController <UITextFieldDelegate>
@property (strong, nonatomic) IBOutlet UIBarButtonItem *revealButtonItem;
@property (strong, nonatomic) IBOutlet UIWebView *webView;

@end
