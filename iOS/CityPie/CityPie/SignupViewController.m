//
//  SignupViewController.m
//  CityPie
//
//  Created by Haifisch Laws on 10/6/13.
//  Copyright (c) 2013 Haifisch Laws. All rights reserved.
//

#import "SignupViewController.h"

@interface SignupViewController ()

@end

@implementation SignupViewController

- (void)viewDidLoad
{
    [super viewDidLoad];
    self.signUpButton.font = [UIFont fontWithName:@"Grand Hotel" size:48];
    self.view.backgroundColor = [UIColor colorWithRed:245/255.0f green:238/255.0f blue:228/255.0f alpha:1];

}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (IBAction)signMeUp:(id)sender {
    
    //NSURL *url = [NSURL URLWithString:@"http://citypie.us/api/1.0/users"];
    self.responseData = [NSMutableData data];
    
    NSMutableURLRequest *request = [NSMutableURLRequest
									requestWithURL:[NSURL URLWithString:@"http://citypie.us/api/1.0/users"]];
    
    NSString *params = [NSString stringWithFormat:@"email=%@&name=%@&password=%@",self.userEmail.text, self.userName.text, self.userPassword.text];
    [request setHTTPMethod:@"POST"];
    [request setHTTPBody:[params dataUsingEncoding:NSUTF8StringEncoding]];
    [[NSURLConnection alloc] initWithRequest:request delegate:self];
}
- (void)connection:(NSURLConnection *)connection didReceiveResponse:(NSURLResponse *)response {
    NSLog(@"didReceiveResponse");
    [self.responseData setLength:0];
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data {
    [self.responseData appendData:data];
}

- (void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error {
    NSLog(@"didFailWithError");
    NSLog([NSString stringWithFormat:@"Connection failed: %@", [error description]]);
}

- (void)connectionDidFinishLoading:(NSURLConnection *)connection {
    NSLog(@"connectionDidFinishLoading");
    NSLog(@"Succeeded! Received %d bytes of data",[self.responseData length]);
    
    // convert to JSON
    NSError *myError = nil;
    NSDictionary *res = [NSJSONSerialization JSONObjectWithData:self.responseData options:NSJSONReadingMutableLeaves error:&myError];
    
    // show all values
    /*for(id key in res) {
        
        id value = [res objectForKey:key];
        
        NSString *keyAsString = (NSString *)key;
        NSString *valueAsString = (NSString *)value;
        
        NSLog(@"key: %@", keyAsString);
        NSLog(@"value: %@", valueAsString);
    }*/
    NSLog(@"%@", res);
    //NSLog(@"%@", [[res objectForKey:@"data"] objectForKey:@"created"]);
    NSLog(@"%@", [res objectForKey:@"status"]);
   // NSLog(@"%@", [res objectForKey:@"errors"]);

    if ([[res objectForKey:@"status"]  isEqual: @"error"]){
        NSArray *errors = [[NSArray alloc] initWithArray:[res objectForKey:@"errors"]];
       // NSLog(@"%@", errors);
        UIAlertView *errorAlert = [[UIAlertView alloc] initWithTitle:@"Oh no!" message:[NSString stringWithFormat:@"%@",[errors objectAtIndex:0]] delegate:self cancelButtonTitle:@"Ok" otherButtonTitles:nil, nil];
        [errorAlert show];
    }else {
        NSUserDefaults *storage =  [NSUserDefaults standardUserDefaults];
        [storage setBool:YES forKey:@"loggedin"];
        NSLog(@"%@",[storage objectForKey:@"loggedin"]);
        [storage setValue:[[res objectForKey:@"data"] objectForKey:@"id"] forKey:@"user_id"];
        [self dismissViewControllerAnimated:YES completion:nil];

    }
    // extract specific value...
    //NSArray *results = [res objectForKey:@"data"];
    
    /*for (NSDictionary *result in results) {
        NSString *icon = [result objectForKey:@"created"];
        NSLog(@"icon: %@", icon);
    }*/
    
}
-(BOOL) textFieldShouldReturn:(UITextField *)textField{
    [textField resignFirstResponder];
    return YES;
}
- (IBAction)cancel:(id)sender {
    [self dismissViewControllerAnimated:YES completion:nil];
}
@end
