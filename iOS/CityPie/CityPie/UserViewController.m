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


- (void)viewDidLoad
{
    [super viewDidLoad];
    [self loadData];
    //self.userImage.layer.cornerRadius = self.u.size.width / 2;
    //self.userImage.layer.masksToBounds = YES;
    self.userInfoView.backgroundColor = [UIColor colorWithRed:245/255.0f green:238/255.0f blue:228/255.0f alpha:1];

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
    NSLog(@"connectionDidFinishLoading...");
    NSError *error = nil;
    //id result = [NSJSONSerialization JSONObjectWithData:self.receivedData options:kNilOptions error:&error];
    NSDictionary *jsonData = [NSJSONSerialization JSONObjectWithData:self.receivedData options:kNilOptions error:&error];
    self.title = [[jsonData objectForKey:@"data"] objectForKey:@"name"];
   // self.userImage = [[jsonData objectForKey:@"data"] objectForKey:@"pic"];
    NSURL * imageURL = [NSURL URLWithString:[NSString stringWithFormat:@"%@%@", BASE, [[jsonData objectForKey:@"data"] objectForKey:@"pic"]]];
    NSData * imageData = [NSData dataWithContentsOfURL:imageURL];
    UIImage * image = [UIImage imageWithData:imageData];
    self.userImage.layer.cornerRadius = image.size.width / 8;
    self.userImage.layer.masksToBounds = YES;
    self.userImage.image = image;
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
@end
